<?php

namespace App\Http\Controllers;

use App\Sidebar;
use App\SidebarContent;
use Illuminate\Http\Request;
use Session;

class SidebarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit      =   100;
        $sidebars   = Sidebar::paginate($limit);
        return view('admin/sidebars',['sidebars' => $sidebars,'limit' =>  $limit]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/create_sidebar');
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
            'sidebar_name'        => 'required|max:255',
            'sidebar_type'        => 'required|max:255',
            'topics'              => 'required|max:255',
        ]);

        

        if(count($request->topics)){
            $sidebar        =   new Sidebar;
            $sidebar->sidebar_name  =   $request->sidebar_name;        
            $sidebar->sidebar_type  =   $request->sidebar_type;        
            $sidebar->save();

            foreach($request->topics as $topic)
            {
                $content                    =   new SidebarContent;
                $content->sidebar_id        =   $sidebar->id;
                $content->destination_id    =   $topic;
                $content->save();
            }
            Session::flash('alert-success', 'Sidebar added successfully');
            return redirect(route('sidebars.index'));
        }   
        else{
            Session::flash('alert-warning', 'Please add topics to sidebar');
            return redirect(route('sidebars.create'));
        }        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sidebar  $sidebar
     * @return \Illuminate\Http\Response
     */
    public function show(Sidebar $sidebar)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sidebar  $sidebar
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sidebar    =   Sidebar::With('sidebar_content')->findOrFail($id);
        return view('admin/edit_sidebar',['sidebar' =>  $sidebar]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sidebar  $sidebar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $request->validate([
            'sidebar_name'        => 'required|max:255',
            'sidebar_type'        => 'required|max:255',
            'topics'              => 'required|max:255',
        ]);

        

        if(count($request->topics)){
            $sidebar        =   Sidebar::findOrFail($id);
            $sidebar->sidebar_name  =   $request->sidebar_name;        
            $sidebar->sidebar_type  =   $request->sidebar_type;        
            $sidebar->save();

            SidebarContent::where('sidebar_id',$id)->delete();

            foreach($request->topics as $topic)
            {
                $content                    =   new SidebarContent;
                $content->sidebar_id        =   $sidebar->id;
                $content->destination_id    =   $topic;
                $content->save();
            }
            Session::flash('alert-success', 'Sidebar updated successfully');
            return redirect(route('sidebars.index'));
        }   
        else{
            Session::flash('alert-warning', 'Please add topics to sidebar');
            return redirect(route('sidebars.update',$id));
        }      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sidebar  $sidebar
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tut            =   Sidebar::findOrFail($id); 
        SidebarContent::where('sidebar_id',$id)->delete();     
        $tut->delete();
        Session::flash('alert-success', 'Sidebar deleted successfully');
        return redirect(route('sidebars.index'));
    }
}
