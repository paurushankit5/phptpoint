<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Tutorial;
use App\Slug;
use Session;
class TutorialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit      =   100;
        $tutorials =   Tutorial::paginate($limit);
        return view('admin.tutorial',['tutorials'  =>  $tutorials,'limit' =>  $limit]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.create_tutorials',['categories'  =>  $categories]);
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
            'tutorial_name' => 'required|max:255',
            'content'       => 'required',
            'page_title'    => 'required|max:255',
        ]);
        $slug                   =   new Slug;
        $slug->slug             =   $request->slug;
        $slug ->method_name     =   "Pagecontroller@gettutorial";
        $slug->save();  

        $tut                    =   new Tutorial;
        $tut->category_id       =   $request->category_id;
        $tut->tut_name          =   $request->tutorial_name;
        $tut->page_name         =   $request->page_name;
        $tut->status            =   $request->status;
        $tut->content           =   $request->content;
        $tut->page_title        =   $request->page_title;
        $tut->meta_title        =   $request->meta_title;
        $tut->meta_keyword      =   $request->meta_keyword;
        $tut->meta_description  =   $request->meta_description;
        $tut->slug_id           =   $slug->id;
        $tut->save();

        Session::flash('alert-success', 'Tutorial added successfully');
        return redirect(route('tutorials.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tutorial   =   Tutorial::findOrFail($id);
        return view('admin.show_tutorial',['tutorial'   =>  $tutorial]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $tutorial   =   Tutorial::findOrFail($id);
        return view('admin.edit_tutorial',['tutorial'   =>  $tutorial ,'categories' =>  $categories]);
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
        $tut       =   Tutorial::findOrFail($id);
        $request->validate([
            'slug'          => 'required|max:255|unique:slugs,slug,'.$tut->slug_id,
            'tutorial_name' => 'required|max:255',
            'content'       => 'required',
            'page_title'    => 'required|max:255',
        ]);

        $slug                   =   Slug::findOrFail($tut->slug_id);
        $slug->slug             =   $request->slug;
        $slug->save();  

        $tut->category_id       =   $request->category_id;
        $tut->tut_name          =   $request->tutorial_name;
        $tut->page_name         =   $request->page_name;
        $tut->status            =   $request->status;
        $tut->content           =   $request->content;
        $tut->page_title        =   $request->page_title;
        $tut->meta_title        =   $request->meta_title;
        $tut->meta_keyword      =   $request->meta_keyword;
        $tut->meta_description  =   $request->meta_description;
        $tut->save();

        Session::flash('alert-success', 'Tutorial updated successfully');
        return redirect(route('tutorials.show', $tut->id));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tut            =   Tutorial::findOrFail($id);
        $tut->delete();
        Session::flash('alert-success', 'Tutorial deleted successfully');
        return redirect(route('tutorials.index'));
    }
}
