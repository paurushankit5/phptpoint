<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\Tutorial;
use App\Subtutorial;
use App\Project;

class AjaxController extends Controller
{
    

    public function getalllistfromtable(Request $request)
    {
        if($request->table == 'tutorial')
        {
        	return json_encode(Tutorial::select('tutorials.id','tut_name as name' )
        		->get());
        }
        else if($request->table == 'sub_tutorial')
        {
        	return json_encode(Subtutorial::select("subtutorials.id",\DB::raw("concat(tut_name, ' | ', subtut_name ) as name") )
        		->join('tutorials','tutorials.id','=','subtutorials.tutorial_id')
        		->orderBy('tut_name')
        		->get());
        }
        else if($request->table == 'free_project')
        {
        	return json_encode(Project::select('projects.id','pro_name as name' )
        		->where('is_paid',false)
        		->get());
        }
         else if($request->table == 'paid_project')
        {
        	return json_encode(Project::select('projects.id','pro_name as name' )
        		->where('is_paid',true)
        		->get());
        }
        else if($request->table == 'page')
        {
        	return json_encode(Page::select('pages.id','page_name as name' )
        		->get());
        }
        
        
        
    }
}
