<?php

//https://laravel.com/docs/8.x/authentication
//https://www.positronx.io/laravel-custom-authentication-login-and-registration-tutorial/ -->also has some blade info
//https://remotestack.io/how-to-create-custom-auth-login-and-registration-in-laravel/
//https://fusionauth.io/blog/2020/06/03/user-registration-and-sign-in-with-laravel/

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = '/admin';

    public function showLoginForm() {
        return view('auth.admin');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->middleware('guest')->except('logout');

        // prevents admin from accessing this page if logged in
        $this->middleware('guest:admin')->except('logout');
    }


    public function getUser(){
        return $request->user();
    }

    public function home() {
        return redirect('/admin');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
        $hi='im here';
        

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended(route('admin.admin_view_users'))->withSuccess('Signed in');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request) {
        Auth::guard('admin')->logout();

        Session::flush();

        return redirect('/');
    }
}