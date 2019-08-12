<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Session;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $limit      =   env('PAGINATION_LIMIT', 10);
        $query      =   User::where('id','<>', \Auth::id());
        if(!empty($_GET['search'])){
            $search = $_GET['search'];
            $query->whereRaw("name like '%$search%' ");
        }
        $users  =   $query->paginate($limit);
        return view('admin.users',['users'  =>  $users,'limit' =>  $limit]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user =     User::findOrFail($id);
        $array  = ['user'   =>  $user];
        return view('admin.show_user',$array);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //$user =     User::findOrFail($id);
        $array  = ['user'   =>  $user];
        return view('admin.edit_user',$array);
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
            'email'          => 'required|unique:users,email,'.$request->email,
            'email'          => 'unique:users,mobile,'.$request->mobile,
        ]);
        $user = User::findOrFail($id);
        $user->email = $request->email;
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->status = $request->status;

        if($request->user_type == 'student'){
            $user->is_student = 1;
            $user->is_author  = 0;
        }
        else if($request->user_type == 'author'){
            $user->is_student = 0;
            $user->is_author  = 1;
        }
        $user->save();
        Session::flash('alert-success', 'User updated successfully');
        return redirect(route('users.show', $user->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function changePassword(){
        if(\Auth::check()) {
            return view('changePassword');
        }
        return redirect('/login');
    }

    public function updatePassword(Request $request){
        if(\Auth::check()) {
            $this->validate($request, [
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
            ]);
            \Auth::user()->password = Hash::make($request->password);
            \Auth::user()->save();
            Session::flash('alert-success', 'Password updated successfully');
            if(\Auth::user()->is_admin)
            {
                return redirect('/phpadmin');
            }
            return  redirect('/');
        }
        return redirect('/login');
    }
}
