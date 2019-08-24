<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Add;
use Session;    

class AddController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $limit      =   env('PAGINATION_LIMIT', 10);
        $query      =   Add::where('add_name','<>','');
        if(!empty($_GET['search'])){
            $search = $_GET['search'];
            $query->whereRaw("add_name like '%$search%' ");
        }
        $adds  =   $query->paginate($limit);
        return view('admin.adds',['adds'  =>  $adds,'limit' =>  $limit]);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create_adds');
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
            'add_name'      => 'required|max:255',
            'add_type'      => 'required|max:255',
            'content'       => 'required',
        ]);
        $add                    =   new Add;
        $add->add_name       =   $request->add_name;
        $add->content        =   $request->content;
        $add->add_type        =   $request->add_type;
        $add->save();

        $add->save();

        Session::flash('alert-success', 'Advertisement added successfully');
        return redirect(route('adds.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $add   =   Add::findOrFail($id);
        return view('admin.edit_add',['add' =>  $add]);
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
         $request->validate([
            'add_name'      => 'required|max:255',
            'add_type'      => 'required|max:255',
            'content'       => 'required',
        ]);
        $add                 =   Add::findOrFail($id);
        $add->add_name       =   $request->add_name;
        $add->add_type       =   $request->add_type;
        $add->content        =   $request->content;
        $add->save();

        $add->save();

        Session::flash('alert-success', 'Advertisement added successfully');
        return redirect(route('adds.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $add            =   Add::findOrFail($id);

        $add->delete();
        Session::flash('alert-success', 'Add deleted successfully');
        return redirect(route('adds.index'));
    }
}
