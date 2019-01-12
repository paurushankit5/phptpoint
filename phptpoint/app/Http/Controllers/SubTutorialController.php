<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Tutorial;
use App\Subtutorial;
use App\Slug;
use Session;

class SubTutorialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit          =   100;
        $subtutorials   =   Subtutorial::paginate($limit);
        return view('admin.subtutorial',['subtutorials'  =>  $subtutorials,'limit' =>  $limit]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tutorials = Tutorial::orderBy('tut_name')->get();
        return view('admin.create_subtutorials',['tutorials'  =>  $tutorials]);
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
            'slug'              => 'required|unique:slugs,slug|max:255',
            'sub_tutorial_name' => 'required|max:255',
            'tutorial_id'       => 'required',
            'content'           => 'required',
            'page_title'        => 'required|max:255',
        ]);
        $slug                   =   new Slug;
        $slug->slug             =   $request->slug;
        $slug ->method_name     =   "Pagecontroller@getsubtutorial";
        $slug->save();  

        $order                  =    Subtutorial::where('tutorial_id',$request->tutorial_id)->count();

        $tut                    =   new Subtutorial;
        $tut->tutorial_id       =   $request->tutorial_id;
        $tut->subtut_order      =   ++$order;
        $tut->subtut_name       =   $request->sub_tutorial_name;
        $tut->page_name         =   $request->page_name;
        $tut->status            =   $request->status;
        $tut->content           =   $request->content;
        $tut->page_title        =   $request->page_title;
        $tut->meta_title        =   $request->meta_title;
        $tut->meta_keyword      =   $request->meta_keyword;
        $tut->meta_description  =   $request->meta_description;
        $tut->slug_id           =   $slug->id;
        $tut->save();

        Session::flash('alert-success', 'Sub-Tutorial added successfully');
        return redirect(route('subtutorials.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subtutorial   =   Subtutorial::findOrFail($id);
        return view('admin.show_subtutorial',['subtutorial'   =>  $subtutorial]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tutorials = Tutorial::orderBy('tut_name')->get();
        $subtutorial = Subtutorial::findOrFail($id);
        return view('admin.edit_subtutorials',['tutorials'  =>  $tutorials,'subtutorial' =>  $subtutorial]);
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
        $tut       =   Subtutorial::findOrFail($id);
        $request->validate([
            'slug'              => 'required|max:255|unique:slugs,slug,'.$tut->slug_id,
            'sub_tutorial_name' => 'required|max:255',
            'tutorial_id'       => 'required',
            'content'           => 'required',
            'page_title'        => 'required|max:255',
        ]);

        $slug                   =   Slug::findOrFail($tut->slug_id);
        $slug->slug             =   $request->slug;
        $slug->save();  

        $tut->tutorial_id       =   $request->tutorial_id;
        $tut->subtut_name       =   $request->sub_tutorial_name;
        $tut->page_name         =   $request->page_name;
        $tut->status            =   $request->status;
        $tut->content           =   $request->content;
        $tut->page_title        =   $request->page_title;
        $tut->meta_title        =   $request->meta_title;
        $tut->meta_keyword      =   $request->meta_keyword;
        $tut->meta_description  =   $request->meta_description;
        $tut->slug_id           =   $slug->id;
        $tut->save();

        Session::flash('alert-success', 'Sub-Tutorial updated successfully');
        return redirect(route('subtutorials.show', $tut->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tut            =   Subtutorial::findOrFail($id);
        $tut->delete();
        Session::flash('alert-success', 'Sub-Tutorial deleted successfully');
        return redirect(route('subtutorials.index'));
    }
}
