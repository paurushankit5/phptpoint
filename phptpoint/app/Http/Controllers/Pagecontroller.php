<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tutorial;
use App\Subtutorial;

class Pagecontroller extends Controller
{
    public function gettutorial($slug_id){
    	$tut 	=  Tutorial::with('subtutorial')->where('slug_id',$slug_id)->first();
    	return view('tutorial',['tut' => $tut]);
    }

    public function getsubtutorial($slug_id){
    	$subtut 	=  Subtutorial::with('tutorial')->where('slug_id',$slug_id)->first();
    	$next_slug 	= 	Subtutorial::where('slug_id','>',$slug_id)
    									->where('tutorial_id', $subtut->tutorial_id)
    									->orderBy('slug_id','ASC')
    									->first();
    	$prev_slug 	= 	Subtutorial::where('slug_id','<',$slug_id)
    									->where('tutorial_id', $subtut->tutorial_id)
    									->orderBy('slug_id','DESC')
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


}
