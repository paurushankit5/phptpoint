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
    	return view('subtutorial',['subtut' => $subtut]);
    }


}
