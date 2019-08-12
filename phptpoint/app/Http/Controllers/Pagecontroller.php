<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tutorial;
use App\Subtutorial;
use App\Project;
use App\Page;
use App\Blog;

class Pagecontroller extends Controller
{
    public function gettutorial($slug_id){
    	$tut 	=  Tutorial::with('subtutorial')->where('slug_id',$slug_id)->firstOrFail();
    	return view('tutorial',['tut' => $tut]);
    }

    public function getsubtutorial($slug_id){
    	$subtut 	=  Subtutorial::with('tutorial')->where('slug_id',$slug_id)->first();
    	$next_slug 	= 	Subtutorial::where('subtut_order','>',$subtut->subtut_order)
    									->where('tutorial_id', $subtut->tutorial_id)
    									->orderBy('subtut_order','ASC')
    									->first();
    	$prev_slug 	= 	Subtutorial::where('subtut_order','<',$subtut->subtut_order)
    									->where('tutorial_id', $subtut->tutorial_id)
    									->orderBy('subtut_order','DESC')
    									->first();
    	if($prev_slug)
    	{
    		$prev_slug 	= 	$prev_slug->slug->slug;
    	}
    	if($next_slug)
    	{
    		$next_slug 	= 	$next_slug->slug->slug;
    	}
    	//	return $prev_slug;
    	return view('subtutorial',[	
    							'subtut' => $subtut,
    							'next_slug' 	=> 	$next_slug,
    							'prev_slug' 	=> 	$prev_slug,
    						]);
    }

    public function getproject($slug_id){
        $pro    =   Project::where('slug_id',$slug_id)->firstOrFail();
        $projects   =   Project::where('is_paid',$pro->is_paid)->get();
        return view('project',[
            "pro"        =>  $pro,
            "projects"   =>  $projects,
        ]);
    }

    public function getstaticpage($slug_id){
        $page    =   Page::where('slug_id',$slug_id)->firstOrFail();
        return view('page',[
            "page"        =>  $page,
        ]);
    }
    public function getblog($slug_id){
        $blog   =   Blog::where('slug_id', $slug_id)->firstOrFail();
        $recent_blogs = Blog::where('id','<>', $blog->id)->with('slug')->paginate(10);
        $array  =   array(
                            "blog"  =>  $blog,
                            "recent_blogs"  =>  $recent_blogs
                        );
        return view('blog', $array);
    }
}
