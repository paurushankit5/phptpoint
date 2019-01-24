<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Tutorial;
use App\Project;
use App\Page;

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
}
