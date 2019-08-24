<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Tutorial;
use App\Subtutorial;
use App\Sidebar;
use App\LinkSidebar;
use App\Slug;
use Session;
use Plupload;

class TutorialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit      =   env('PAGINATION_LIMIT', 10);
        $query      =   Tutorial::where('deleted_at', null);
        if(!empty($_GET['search'])){
            $search = $_GET['search'];
            $query->whereRaw("tut_name like '%$search%' ");
        }
        $tutorials  =   $query->paginate($limit);
        return view('admin.tutorial',['tutorials'  =>  $tutorials,'limit' =>  $limit]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $sidebars = Sidebar::all();

        return view('admin.create_tutorials',['categories'  =>  $categories,'sidebars'  =>  $sidebars]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'slug'          => 'required|unique:slugs,slug|max:255',
            'tutorial_name' => 'required|max:255',
            'content'       => 'required',
            'page_title'    => 'required|max:255',
            'image' => 'required|mimes:jpeg,jpg,png|max:2048',
        ]);
        $slug                   =   new Slug;
        $slug->slug             =   $request->slug;
        $slug ->method_name     =   "Pagecontroller@gettutorial";
        $slug->save();  

        $tut                    =   new Tutorial;
        $tut->category_id       =   $request->category_id;
        $tut->tut_name          =   $request->tutorial_name;
        $tut->page_name         =   $request->page_name;
        $tut->status            =   $request->status;
        $tut->content           =   $request->content;
        $tut->page_title        =   $request->page_title;
        $tut->meta_title        =   $request->meta_title;
        $tut->meta_keyword      =   $request->meta_keyword;
        $tut->meta_description  =   $request->meta_description;
        $tut->slug_id           =   $slug->id;
        if(!empty($_FILES['image']) && !empty($_FILES['image']['name']))
        {
            $tut->image     =   CommonController::uploadImage($request);
        }

        $tut->save();

        if(count($request->sidebars))
        {
            foreach ($request->sidebars as $sidebar) {
                $side   =   new LinkSidebar;
                $side->sidebar_type     =   'tutorial';
                $side->sidebar_id       =   $sidebar;
                $side->source_page_id   =   $tut->id;
                $side->save();
            }
        }

        Session::flash('alert-success', 'Tutorial added successfully');
        return redirect(route('tutorials.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tutorial   =   Tutorial::findOrFail($id);
        $sidebars   =   Linksidebar::where(['sidebar_type'   =>  'tutorial','source_page_id' => $tutorial->id])->get();
        return view('admin.show_tutorial',['tutorial'   =>  $tutorial,'sidebars'    =>  $sidebars]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $tutorial   =   Tutorial::findOrFail($id);
        $sidebars = Sidebar::all();
        $linked_sidebar = LinkSidebar::where(['sidebar_type' => 'tutorial','source_page_id' =>  $id])->select('sidebar_id')->get();
        $linked_sidebar = $linked_sidebar->toArray();
        if(count($linked_sidebar))
        {
            $tmp    = array();
            foreach ($linked_sidebar as $link) {
                array_push($tmp,$link['sidebar_id']);
            }
            $linked_sidebar = $tmp;
        }
        return view('admin.edit_tutorial',['tutorial'   =>  $tutorial ,'categories' =>  $categories,'sidebars' => $sidebars,'linked_sidebar'=> $linked_sidebar]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tut       =   Tutorial::findOrFail($id);
        $request->validate([
            'slug'          => 'required|max:255|unique:slugs,slug,'.$tut->slug_id,
            'tutorial_name' => 'required|max:255',
            'content'       => 'required',
            'page_title'    => 'required|max:255',
            'image' => 'mimes:jpeg,jpg,png|max:2048',

        ]);

        $slug                   =   Slug::findOrFail($tut->slug_id);
        $slug->slug             =   $request->slug;
        $slug->save();  

        $tut->category_id       =   $request->category_id;
        $tut->tut_name          =   $request->tutorial_name;
        $tut->page_name         =   $request->page_name;
        $tut->status            =   $request->status;
        $tut->content           =   $request->content;
        $tut->page_title        =   $request->page_title;
        $tut->meta_title        =   $request->meta_title;
        $tut->meta_keyword      =   $request->meta_keyword;
        $tut->meta_description  =   $request->meta_description;

        if(!empty($_FILES['image']) && !empty($_FILES['image']['name']))
        {
            if($tut->image != ''){
                @unlink(public_path('/images/'.$tut->image));
            }
            $tut->image     =   CommonController::uploadImage($request);
        }
        $tut->save();


        LinkSidebar::where(['sidebar_type' => 'tutorial','source_page_id' =>  $id])->delete();

        if(count($request->sidebars))
        {
            foreach ($request->sidebars as $sidebar) {
                $side   =   new LinkSidebar;
                $side->sidebar_type     =   'tutorial';
                $side->sidebar_id       =   $sidebar;
                $side->source_page_id   =   $tut->id;
                $side->save();
            }
        }

        Session::flash('alert-success', 'Tutorial updated successfully');
        return redirect(route('tutorials.show', $tut->id));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tut            =   Tutorial::findOrFail($id);
        
        $tut->delete();
        Session::flash('alert-success', 'Tutorial deleted successfully');
        return redirect(route('tutorials.index'));
    }

    public function arrangesubtutorials($id){
        $tutorial = Tutorial::with('subtutorial')->find($id);  

        $array  =   array('tut' =>  $tutorial);
        return view ('admin.arrangesubtutorials',$array);
    }
    public function saveSubtutOrder(Request $request){
        if(count($request->ids)){
            $i=1;
            foreach($request->ids as $id){
                $subtut = Subtutorial::findOrFail($id);
                $subtut->subtut_order = $i;
                $subtut->save();
                $i++;
            }
            Session::flash('alert-success', 'Subtutorial arranged successfully');
        }
        return 1;
    }


    public function uploadzip($id){
        //return $id;
        
        return Plupload::receive('file', function ($file) use($id)
        {
            $tutorial = Tutorial::findOrFail($id);
            $file_name = $tutorial->tut_name.'-'.time().'.'.$file->getClientOriginalExtension();
            $file->move(storage_path('app/public/zip/project/'), $file_name);            
            if($tutorial->zip_name != '')
            {
                @unlink(storage_path('app/public/zip/project/'.$tutorial->zip_name));
            }
            $tutorial->zip_name = $file_name;
            $tutorial->save();
            return 'ready';
        });
    }
}
