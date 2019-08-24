<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Sidebar;
use App\LinkSidebar;
use App\Slug;
use Session;
use Plupload;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit      =   100;
        $projects =   Project::orderBy('id','DESC')->paginate($limit);
        return view('admin.projects',['projects'  =>  $projects,'limit' =>  $limit]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sidebars = Sidebar::all();
        return view ('admin.create_projects',['sidebars'    =>  $sidebars]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(isset($_FILES['pro_image']['name']) && $_FILES['pro_image']['name']!='')
        {
            $request->validate([
                'slug'          => 'required|unique:slugs,slug|max:255',
                'project_name' => 'required|max:255',
                'content'       => 'required',
                'page_title'    => 'required',
                'pro_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]); 
            $image = $request->file('pro_image');
            $pro_image = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/projects');
            $image->move($destinationPath, $pro_image);
            
        }
        else{
             $request->validate([
                'slug'          => 'required|unique:slugs,slug|max:255',
                'project_name'  => 'required|max:255',
                'content'       => 'required',
                'page_title'    => 'required',
            ]);
             $pro_image = Null;
        }
        

        $slug                   =   new Slug;
        $slug->slug             =   $request->slug;
        $slug ->method_name     =   "Pagecontroller@getproject";
        $slug->save();  

        $tut                    =   new Project;
        $tut->pro_name          =   $request->project_name;
        $tut->pro_image         =   $pro_image;
        $tut->page_name         =   $request->page_name;
        $tut->video_url         =   $request->youtube_embed_link;
        $tut->is_paid           =   $request->is_paid;
        $tut->price             =   $request->project_price;
        $tut->content           =   $request->content;
        $tut->page_title        =   $request->page_title;
        $tut->meta_title        =   $request->meta_title;
        $tut->meta_keyword      =   $request->meta_keyword;
        $tut->meta_description  =   $request->meta_description;
        $tut->slug_id           =   $slug->id;
        $tut->save();

        if(count($request->sidebars))
        {
            foreach ($request->sidebars as $sidebar) {
                $side   =   new LinkSidebar;
                $side->sidebar_type     =   'project';
                $side->sidebar_id       =   $sidebar;
                $side->source_page_id   =   $tut->id;
                $side->Save();
            }
        }

        Session::flash('alert-success', 'Project added successfully');
        return redirect(route('projects.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project   =   Project::findOrFail($id);
        $sidebars   =   Linksidebar::where(['sidebar_type'   =>  'project','source_page_id' => $project->id])->get();

        return view('admin.show_project',['project'   =>  $project,'sidebars'   =>  $sidebars]);
    }

    /**
     * Show the form for editing the specified resource.
     *  
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project   =   Project::findOrFail($id);
        $sidebars = Sidebar::all();
        $linked_sidebar = LinkSidebar::where(['sidebar_type' => 'project','source_page_id' =>  $id])->select('sidebar_id')->get();
        $linked_sidebar = $linked_sidebar->toArray();
        if(count($linked_sidebar))
        {
            $tmp    = array();
            foreach ($linked_sidebar as $link) {
                array_push($tmp,$link['sidebar_id']);
            }
            $linked_sidebar = $tmp;
        }
        return view('admin.edit_project',['project'   =>  $project,'linked_sidebar' =>  $linked_sidebar,'sidebars'  =>  $sidebars]);
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
        $pro       =   Project::findOrFail($id);
        if(isset($_FILES['pro_image']['name']) && $_FILES['pro_image']['name']!='')
        {
            $request->validate([
                'slug'          => 'required|max:255|unique:slugs,slug,'.$pro->slug_id,
                'project_name' => 'required|max:255',
                'content'       => 'required',
                'page_title'    => 'required',
                'pro_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]); 
            $image = $request->file('pro_image');
            $pro_image = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images/projects');
            $image->move($destinationPath, $pro_image);  
            $pro->pro_image         =   $pro_image;

        }
        else{
             $request->validate([
                'slug'          => 'required|max:255|unique:slugs,slug,'.$pro->slug_id,
                'project_name'  => 'required|max:255',
                'content'       => 'required',
                'page_title'    => 'required',
            ]);
        }



        $slug                   =   Slug::findOrFail($pro->slug_id);
        $slug->slug             =   $request->slug;
        $slug->save(); 
        if($request->project_price == '')
            $request->project_price = 0;

        $pro->pro_name          =   $request->project_name;
        $pro->page_name         =   $request->page_name;
        $pro->video_url         =   $request->youtube_embed_link;
        $pro->is_paid           =   $request->is_paid;
        $pro->price             =   $request->project_price;
        $pro->content           =   $request->content;
        $pro->page_title        =   $request->page_title;
        $pro->meta_title        =   $request->meta_title;
        $pro->meta_keyword      =   $request->meta_keyword;
        $pro->meta_description  =   $request->meta_description;
        $pro->slug_id           =   $slug->id;
        $pro->save();

        LinkSidebar::where(['sidebar_type' => 'project','source_page_id' =>  $id])->delete();

        if(count($request->sidebars))
        {
            foreach ($request->sidebars as $sidebar) {
                $side   =   new LinkSidebar;
                $side->sidebar_type     =   'project';
                $side->sidebar_id       =   $sidebar;
                $side->source_page_id   =   $pro->id;
                $side->Save();
            }
        }

        Session::flash('alert-success', 'Project updated successfully');
        return redirect(route('projects.show',$pro->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pro            =   Project::findOrFail($id);
        
        $pro->delete();
        Session::flash('alert-success', 'Project deleted successfully');
        return redirect(route('projects.index'));
    }

    public function uploadzip($id){
        //return $id;
        
        return Plupload::receive('file', function ($file) use($id)
        {
            $project = Project::findOrFail($id);
            $file_name = $project->pro_name.'-'.time().'.'.$file->getClientOriginalExtension();
            $file->move(storage_path('app/public/zip/project/'), $file_name);            
            if($project->zip_name != '')
            {
                @unlink(storage_path('app/public/zip/project/'.$project->zip_name));
            }
            $project->zip_name = $file_name;
            $project->save();
            return 'ready';
        });
    }
}
