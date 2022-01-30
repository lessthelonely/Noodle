<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB; 
use Carbon\Carbon; 
use App\Models\User; 
use Mail; 
use Illuminate\Support\Str;
use App\Models\PasswordReset;

class PasswordResetController extends Controller
{
    use AuthenticatesUsers;

    public function showForgetPasswordForm(){
       return view('auth.forgetPassword');
    }

    public function submitForgetPasswordForm(Request $request){
        $request->validate([
              'email' => 'required|email|exists:users',
        ]);
          
        $token = Str::random(64);
        $password_reset= new PasswordReset();
        $password_reset->email=$request->email;
        $password_reset->token=$token;
        $password_reset->created_at=Carbon::now();
        $password_reset->save();
        Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
              $message->to($request->email);
              $message->subject('Reset Password');
          });
        return back()->with('message', 'We have e-mailed your password reset link!');
      }

    
    public function showResetPasswordForm($token) { 
        return view('auth.forgetPasswordLink', ['token' => $token]);
    }


    public function submitResetPasswordForm(Request $request) {
        $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed'
        ]);

        $updatePassword = PasswordReset::where('email',$request->email)->where('token',$request->token)->first();

        $user = User::where('email', $request->email)->update(['password' => bcrypt($request->password)]);
        PasswordReset::where('email',$request->email)->delete();

  

        return redirect('/login')->with('message', 'Your password has been changed!');
    }

}
