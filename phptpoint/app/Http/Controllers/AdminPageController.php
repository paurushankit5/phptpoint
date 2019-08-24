<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\Slug;
use App\Sidebar;
use App\LinkSidebar;
use Session;

class AdminPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit          =   env('PAGINATION_LIMIT', 10);
        $query          =   Page::where('deleted_at', null);
        if(!empty($_GET['search'])){
            $search = $_GET['search'];
            $query->whereRaw("page_name like '%$search%' ");
        }
        $pages   =   $query->orderBy('id','DESC')->paginate($limit);
        return view('admin.page',['pages'  =>  $pages,'limit' =>  $limit]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sidebars = Sidebar::all();   
        return view('admin.create_pages',['sidebars'    =>  $sidebars]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->external_link_radio == 1)
        {
            $request->validate([
                'page_name'     => 'required|max:255',
            ]);
            $request->page_title    = '';
            $content    = '';
            $request->slug    = '';
            $request->meta_title    = '';
            $request->meta_keyword    = '';
            $request->meta_description    = '';
            $slug_id= Null;

        }
        else{
            $request->validate([
                'slug'          => 'required|unique:slugs,slug|max:255',
                'page_name'     => 'required|max:255',
                'content'       => 'required',
                'page_title'    => 'required|max:255',
            ]);
            $request->external_link = '';
            $content = $request->content;
        }
        
        if($request->slug!='')
        {
            $slug                   =   new Slug;
            $slug->slug             =   $request->slug;
            $slug ->method_name     =   "Pagecontroller@getstaticpage";
            $slug->save(); 
            $slug_id = $slug->id;

        }

         

        $page                    =   new Page;
        $page->page_name         =   $request->page_name;
        $page->content           =   $content;
        $page->page_title        =   $request->page_title;
        $page->meta_title        =   $request->meta_title;
        $page->meta_keyword      =   $request->meta_keyword;
        $page->meta_description  =   $request->meta_description;
        $page->external_link  =   $request->external_link;
        $page->slug_id           =   $slug_id;
        $page->save();

        if(count($request->sidebars))
        {
            foreach ($request->sidebars as $sidebar) {
                $side   =   new LinkSidebar;
                $side->sidebar_type     =   'page';
                $side->sidebar_id       =   $sidebar;
                $side->source_page_id   =   $page->id;
                $side->Save();
            }
        }

        Session::flash('alert-success', 'Page added successfully');
        return redirect(route('pages.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page   =   Page::findOrFail($id);
        $sidebars   =   Linksidebar::where(['sidebar_type'   =>  'page','source_page_id' => $page->id])->get();
        return view('admin.show_page',['page'   =>  $page,'sidebars'    =>  $sidebars]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page   =   Page::findOrFail($id);
        $sidebars = Sidebar::all();
        $linked_sidebar = LinkSidebar::where(['sidebar_type' => 'page','source_page_id' =>  $id])->select('sidebar_id')->get();
        $linked_sidebar = $linked_sidebar->toArray();
        if(count($linked_sidebar))
        {
            $tmp    = array();
            foreach ($linked_sidebar as $link) {
                array_push($tmp,$link['sidebar_id']);
            }
            $linked_sidebar = $tmp;
        }
        return view('admin.edit_page',['page'   =>  $page,'linked_sidebar'  =>  $linked_sidebar,'sidebars'  =>  $sidebars]);
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
        //return $id;
        $page       =   Page::findOrFail($id);
        if($request->external_link_radio == 1)
        {
            $request->validate([
                'page_name'         => 'required|max:255',
                'external_link'     => 'required',
            ]);
            $request->page_title    = '';
            $content    = '';
            $request->slug    = '';
            $request->meta_title    = '';
            $request->meta_keyword    = '';
            $request->meta_description    = '';
            $slug_id= Null;

        }
        else{
            $request->validate([
                'slug'          => 'required|max:255|unique:slugs,slug,'.$page->slug_id,
                'page_name'     => 'required|max:255',
                'content'       => 'required',
                'page_title'    => 'required|max:255',
            ]);
            $request->external_link = '';
            $content = $request->content;
        }
        
        if($request->slug!='')
        {
            $slug                   =   Slug::find($page->slug_id);
            if(!$slug)
            {
                $slug = new Slug;
            }
            $slug->slug             =   $request->slug;
            $slug ->method_name     =   "Pagecontroller@getstaticpage";
            $slug->save(); 
            $slug_id = $slug->id;

        }
        /*else{
            $slug           =   Slug::find($page->slug_id);
            if($slug)
            {
                $slug->delete();
            }
        }*/

        $page->page_name         =   $request->page_name;
        $page->content           =   $request->content;
        $page->page_title        =   $request->page_title;
        $page->meta_title        =   $request->meta_title;
        $page->meta_keyword      =   $request->meta_keyword;
        $page->meta_description  =   $request->meta_description;
        $page->external_link     =   $request->external_link;
        $page->slug_id           =   $slug_id;
        $page->save();

        LinkSidebar::where(['sidebar_type' => 'page','source_page_id' =>  $id])->delete();

        if(count($request->sidebars))
        {
            foreach ($request->sidebars as $sidebar) {
                $side   =   new LinkSidebar;
                $side->sidebar_type     =   'page';
                $side->sidebar_id       =   $sidebar;
                $side->source_page_id   =   $page->id;
                $side->Save();
            }
        }

        Session::flash('alert-success', 'Page updated successfully');
        return redirect(route('pages.show', $page->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page            =   Page::findOrFail($id);
               
        $page->delete();
        Session::flash('alert-success', 'Page deleted successfully');
        return redirect(route('pages.index'));
    }
}
