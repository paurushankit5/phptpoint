<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Tutorial;

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
        return view('index');
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
        return $menu;

    }
}
