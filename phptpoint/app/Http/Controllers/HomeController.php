<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Tutorial;
use App\Subtutorial;
use App\Project;
use App\Page;
use App\Sidebar;
use App\LinkSidebar;
use App\SidebarContent;

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
        $cat   =   Category::with('tutorial')->get();
        $tutorial   = Tutorial::where('category_id',Null)->get();
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
        $menu['tut']  = $tutorial;
        $menu['free_projects'] = Project::where("is_paid",0)->get();
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
            ->select('page_name as name','slug')
            ->join('slugs','slugs.id','=','pages.slug_id')
            ->first();
            $tutorial->slug= 'projects/'.$tutorial->slug;
            return $tutorial;
        }
        return $sidebar_type;

    }
}
