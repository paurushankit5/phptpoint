<?php

namespace App\Http\Controllers;

use App\Blog;
use App\Sidebar;
use App\Slug;
use App\Tutorial;
use App\LinkSidebar;
use Illuminate\Http\Request;
use Session;    

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit      =   env('PAGINATION_LIMIT', 10);
        $query      =   Blog::where('deleted_at', null);
        if(!empty($_GET['search'])){
            $search = $_GET['search'];
            $query->whereRaw("blog_name like '%$search%' ");
        }
        $blogs  =   $query->paginate($limit);
        return view('admin.blogs',['blogs'  =>  $blogs,'limit' =>  $limit]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sidebars = Sidebar::all();

        return view('admin.create_blogs',['sidebars'  =>  $sidebars]);
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
            'blog_name'     => 'required|max:255',
            'content'       => 'required',
            'page_title'    => 'required|max:255',
            //'image'         => 'required | mimes:jpeg,jpg,png | max:2048',
        ]);
        $slug                   =   new Slug;
        $slug->slug             =   $request->slug;
        $slug ->method_name     =   "Pagecontroller@getblog";
        $slug->save();  

        $blog                    =   new Blog;
        $blog->user_id           =   \Auth::user()->id;
        $blog->blog_name         =   $request->blog_name;
        $blog->status            =   $request->status;
        $blog->content           =   $request->content;
        $blog->page_title        =   $request->page_title;
        $blog->meta_title        =   $request->meta_title;
        $blog->meta_keyword      =   $request->meta_keyword;
        $blog->meta_description  =   $request->meta_description;
        $blog->slug_id           =   $slug->id;
        // if(!empty($_FILES['image']) && !empty($_FILES['image']['name']))
        // {
        //     $tut->image     =   CommonController::uploadImage($request);
        // }

        $blog->save();

        if(!empty($request->sidebars) && count($request->sidebars))
        {
            foreach ($request->sidebars as $sidebar) {
                $side   =   new LinkSidebar;
                $side->sidebar_type     =   'blog';
                $side->sidebar_id       =   $sidebar;
                $side->source_page_id   =   $blog->id;
                $side->save();
            }
        }

        Session::flash('alert-success', 'Blogs added successfully');
        return redirect(route('blogs.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //$blog   =   Blog::findOrFail($id);
        $sidebars   =   Linksidebar::where(['sidebar_type'   =>  'blog','source_page_id' => $blog->id])->get();
        return view('admin.show_blog',['blog'   =>  $blog,'sidebars'    =>  $sidebars]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog   =   Blog::findOrFail($id);
        $sidebars = Sidebar::all();
        $linked_sidebar = LinkSidebar::where(['sidebar_type' => 'blog','source_page_id' =>  $id])->select('sidebar_id')->get();
        $linked_sidebar = $linked_sidebar->toArray();
        if(count($linked_sidebar))
        {
            $tmp    = array();
            foreach ($linked_sidebar as $link) {
                array_push($tmp,$link['sidebar_id']);
            }
            $linked_sidebar = $tmp;
        }
        return view('admin.edit_blog',['blog'   =>  $blog ,'sidebars' => $sidebars,'linked_sidebar'=> $linked_sidebar]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $blog       =   Blog::findOrFail($id);
        $request->validate([
            'slug'          => 'required|max:255|unique:slugs,slug,'.$blog->slug_id,
            'blog_name'     => 'required|max:255',
            'content'       => 'required',
            'page_title'    => 'required|max:255',
            //'image' => 'mimes:jpeg,jpg,png | max:2048',

        ]);

        $slug                   =   Slug::findOrFail($blog->slug_id);
        $slug->slug             =   $request->slug;
        $slug->save();  

        $blog->blog_name         =   $request->blog_name;
        $blog->status            =   $request->status;
        $blog->content           =   $request->content;
        $blog->page_title        =   $request->page_title;
        $blog->meta_title        =   $request->meta_title;
        $blog->meta_keyword      =   $request->meta_keyword;
        $blog->meta_description  =   $request->meta_description;

        // if(!empty($_FILES['image']) && !empty($_FILES['image']['name']))
        // {
        //     if($tut->image != ''){
        //         @unlink(public_path('/images/'.$tut->image));
        //     }
        //     $tut->image     =   CommonController::uploadImage($request);
        // }
        $blog->save();


        LinkSidebar::where(['sidebar_type' => 'blog','source_page_id' =>  $id])->delete();

        if(count($request->sidebars))
        {
            foreach ($request->sidebars as $sidebar) {
                $side   =   new LinkSidebar;
                $side->sidebar_type     =   'blog';
                $side->sidebar_id       =   $sidebar;
                $side->source_page_id   =   $blog->id;
                $side->save();
            }
        }

        Session::flash('alert-success', 'Blog updated successfully');
        return redirect(route('blogs.show', $blog->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {     
        LinkSidebar::where(['sidebar_type' => 'blog','source_page_id' =>  $blog->id])->delete();
 
        $blog->delete();
        Session::flash('alert-success', 'Blog deleted successfully');
        return redirect(route('blogs.index'));
    }
}
