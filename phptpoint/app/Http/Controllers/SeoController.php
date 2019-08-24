<?php

namespace App\Http\Controllers;

use App\Seo;
use Illuminate\Http\Request;
use Session;

class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit      =   env('PAGINATION_LIMIT', 10);
        $query      =   Seo::orderBy('id','ASC');
        if(!empty($_GET['search'])){
            $search = $_GET['search'];
            $query->whereRaw("page_name like '%$search%' ");
        }
        $seos  =   $query->paginate($limit);
        return view('admin.seo',['seos'  =>  $seos,'limit' =>  $limit]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create_seo');

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
            'page_name'          => 'required|unique:seos',
            
        ]);
        $seo    =   new Seo;
        $seo->page_name = $request->page_name;
        $seo->page_title = $request->page_title;
        $seo->meta_title = $request->meta_title;
        $seo->meta_keyword = $request->meta_keyword;
        $seo->meta_description = $request->meta_description;
        $seo->save();
        Session::flash('alert-success', 'SEO added successfully');
        return redirect(route('seo.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Seo  $seo
     * @return \Illuminate\Http\Response
     */
    public function show(Seo $seo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Seo  $seo
     * @return \Illuminate\Http\Response
     */
    public function edit(Seo $seo)
    {
        return view('admin.edit_seo',['seo'  =>  $seo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seo  $seo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seo $seo)
    {
        $request->validate([
            'page_name'          => 'required|max:255|unique:seos,id,'.$seo->id,
        ]);
        $seo->page_name = $request->page_name;
        $seo->page_title = $request->page_title;
        $seo->meta_title = $request->meta_title;
        $seo->meta_keyword = $request->meta_keyword;
        $seo->meta_description = $request->meta_description;
        $seo->save();
        Session::flash('alert-success', 'SEO updated successfully');
        return redirect(route('seo.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seo  $seo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seo $seo)
    {
        
        $seo->delete();
        Session::flash('alert-success', 'SEO deleted successfully');
        return redirect(route('seo.index'));
    }
}
