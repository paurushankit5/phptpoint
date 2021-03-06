<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Tutorial;
use App\Subtutorial;
use App\Project;
use App\Page;
use App\Slug;
use App\User;
use App\Sidebar;
use App\LinkSidebar;
use App\SidebarContent;
use App\Download;
use App\Enquiry;
use Session;
use Mail;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        if(Session::has('url')){
            Session()->forget('url');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {     
        //dd($cat[1]);
        $tutorial   =   Tutorial::with('slug')->get();
        return view('index',['tutorial' =>  $tutorial]);
    }

    public static function getmenubar(){
        $cat   =   Category::with('tutorial')->where('is_top_menu',1)->get();
        $tutorial   = Tutorial::where('category_id',null)->get();
        $alltutorial =  Tutorial::orderBy('id','DESC')->limit(5)->get();
        $menu=  array();
        if(count($cat))
        {
            $i= 0;
            foreach($cat as $c)
            {
                if(isset($c->tutorial) && count($c->tutorial))
                {
                    $menu['cat'][$i++] = $c;
                }
            }
        }
        $menu['cat']  = $cat;
        $menu['tut']  = $tutorial;
        $menu['alltutorial']  = $alltutorial;
        $menu['free_projects'] = Project::where("is_paid",0)->where('is_top_menu',1)->get();
        $menu['about'] = Page::all();
        return $menu;

    }

    public static function getsidebars($sidebar_type= Null, $source_page_id = Null){
        $linked_sidebar     =   LinkSidebar::with('sidebar')->where(['sidebar_type' => $sidebar_type,'source_page_id' => $source_page_id])->get();
        return $linked_sidebar;
    }

    public static function getsidebarcontent($destination_id= Null,$sidebar_type=Null){

        if($sidebar_type=='tutorial')
        {
            $tutorial = Tutorial::where(['tutorials.id' => $destination_id])
            ->select('tut_name as name','slug')
            ->join('slugs','slugs.id','=','tutorials.slug_id')
            ->first();
            return $tutorial;
        }
        else if($sidebar_type=='sub_tutorial')
        {
            $tutorial = Subtutorial::where(['subtutorials.id' => $destination_id])
            ->select('subtut_name as name','slug')
            ->join('slugs','slugs.id','=','subtutorials.slug_id')
            ->first();
            return $tutorial;
        }
        else if($sidebar_type=='free_project')
        {
            $tutorial = Project::where(['projects.id' => $destination_id])
            ->select('pro_name as name','slug')
            ->join('slugs','slugs.id','=','projects.slug_id')
            ->first();
            $tutorial->slug= 'projects/'.$tutorial->slug;
            return $tutorial;
        }
        else if($sidebar_type=='paid_project')
        {
            $tutorial = Project::where(['projects.id' => $destination_id])
            ->select('pro_name as name','slug')
            ->join('slugs','slugs.id','=','projects.slug_id')
            ->first();
            $tutorial->slug= 'projects/'.$tutorial->slug;
            return $tutorial;
        }
        else if($sidebar_type=='page')
        {
            $tutorial = Page::where(['pages.id' => $destination_id])
            ->select('page_name as name','slug','external_link')
            ->leftJoin('slugs','slugs.id','=','pages.slug_id')
            ->first();
            return $tutorial;
        }
        return $sidebar_type;

    }
    public function getprojectfile($id){
        \Log::info('Downloading zip for ');
        if(\Auth::check()){
            $project  = Project::select('zip_name')
                        ->join('slugs','slugs.id','=','slug_id')
                        ->where(['projects.id' => $id])
                        ->firstOrFail();
            if($project && $project->zip_name !='')
            {
                $obj    =   new Download;
                $obj->user_id   =   \Auth::id();
                $obj->project_id    =   $id;
                $obj->save();
                return response()->download(storage_path('app/public/zip/project/'.$project->zip_name));
            } 
            else{
                Session::flash('alert-warning', 'Invalid Request');
                return back();
            }
        }
        return redirect('/login');    
    }
    
    public function gettutorialfile($id){
        \Log::info('Downloading zip for ');
        if(\Auth::check()){
            $project  = Tutorial::select('zip_name')
                        ->join('slugs','slugs.id','=','slug_id')
                        ->where(['tutorials.id' => $id])
                        ->firstOrFail();


            if($project && $project->zip_name !='')
            {
                $obj    =   new Download;
                $obj->user_id   =   \Auth::id();
                $obj->tutorial_id    =   $id;
                if($obj->save()){
                    return response()->download(storage_path('app/public/zip/project/'.$project->zip_name));
                }
                else{
                    echo "not saved";
                }
                //return response()->download(storage_path('app/public/zip/project/'.$project->zip_name));
            } 
            else{
                Session::flash('alert-warning', 'Invalid Request');
                return back();
            }
        }
        return redirect('/login');    
    }
    
    public function getsubtutorialfile($id){
        \Log::info('Downloading zip for ');
        if(\Auth::check()){
            $project  = Subtutorial::select('zip_name')
                        ->join('slugs','slugs.id','=','slug_id')
                        ->where(['subtutorials.id' => $id])
                        ->firstOrFail();


            if($project && $project->zip_name !='')
            {
                $obj    =   new Download;
                $obj->user_id   =   \Auth::id();
                $obj->subtutorial_id    =   $id;
                if($obj->save()){
                    return response()->download(storage_path('app/public/zip/project/'.$project->zip_name));
                }
                else{
                    echo "not saved";
                }
                //return response()->download(storage_path('app/public/zip/project/'.$project->zip_name));
            } 
            else{
                Session::flash('alert-warning', 'Invalid Request');
                return back();
            }
        }
        return redirect('/login');    
    }





    public function loginToDownload(Request $request,$slug){
        $param = $request->input();
        //if(isset($param['page']) && !empty($param['page']) && ($param['page'] == 'tutorial') || $param['page'] == 'subtutorial' )
            Session::put('url', "/$slug");  
        // else if(isset($param['page']) && !empty($param['page']) && ($param['page'] ==  'project')  )
        //     Session::put('url', "/projects/$slug");  
        return redirect('/login');
    }

    public function adminDashboard(){
        return view('admin.dashboard');
    }

    public function contactUs(){
        return view('contactus');
    }
    public function saveContactMessage(Request $request){
        $enq    = new Enquiry;
        $enq->name = $request->name;
        $enq->email = $request->email;
        $enq->mobile = $request->mobile;
        $enq->message = $request->message;
        $enq->save();
        $subject = env('APP_NAME')." enquiry from ".$request->name;
        $res = Mail::send('email.contact', ['request' =>   $request], function($message) use ($subject) {
         $message->to(env('CONTACT_RECEIVER_EMAIL',"paurushankit5@gmmil.com"), env('APP_NAME'))->subject($subject);
         $message->from( env('MAIL_FROM_ADDRESS') ,env('MAIL_FROM_NAME'));
      });
        Session::flash('alert-success', 'We have recieved your message. We will get back to you soon.');
        return back();
    }

    public function search(Request $request){
        $q = $request->input('q');
        if(empty($q))
            return redirect('/');
        $tutorial = Tutorial::whereRaw("tut_name like '%$q%'")->where('status',1)->get();
        $subtutorial = Subtutorial::whereRaw("subtut_name like '%$q%'")->where('status',1)->get();
        $array = array('search_tutorial'    =>  $tutorial, 'search_subtutorial' =>  $subtutorial);
        return view('search',$array);
    }

    public function getHints(Request $request){
        $q = $request->input('q');
        $tutorial = Tutorial::select('tut_name as name','slug')
                            ->join('slugs','slugs.id','=','tutorials.slug_id')
                            ->whereRaw("tut_name like '%$q%'")->where('status',1)
                            ->get();
        $subtutorial = Subtutorial::select('subtut_name as name','slug')
                                    ->join('slugs','slugs.id','=','subtutorials.slug_id')
                                    ->whereRaw("subtut_name like '%$q%'")
                                    ->where('status',1)
                                    ->get();
        return array('tutorial'   =>  $tutorial, 'subtutorial' => $subtutorial);
    }

    public function sendmail(){
        $_SESSION['test'] = 1;
        Session::flash('alert-danger', 'Please verify your email to login.');
        echo env('SESSION_LIFETIME');
        $user = User::where('is_Admin',1)->firstOrFail();
        \Auth::login($user);
        //return redirect('\phpadmin');
    }
}
