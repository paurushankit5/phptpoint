<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\Slug;
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
        $limit      =   100;
        $pages =   Page::orderBy('id','DESC')->paginate($limit);
        return view('admin.page',['pages'  =>  $pages,'limit' =>  $limit]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin.create_pages');
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
        return view('admin.show_page',['page'   =>  $page]);
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
        return view('admin.edit_page',['page'   =>  $page]);
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
