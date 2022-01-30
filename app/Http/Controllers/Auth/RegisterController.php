<?php

//https://codeanddeploy.com/blog/laravel/laravel-8-authentication-login-and-registration-with-username-or-email --> has views?
//https://vegibit.com/how-to-create-user-registration-in-laravel/
//https://stackoverflow.com/questions/48289137/post-value-radio-button-with-laravel
//https://www.youtube.com/watch?v=376vZ1wNYPA&list=WL&index=96

namespace App\Http\Controllers\Auth;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/choose-path';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
            return Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|confirmed|min:6', //confirmed checks that it's written the same password
                'profile-pic' => 'required|mimes:jpg,png,jpeg|max:5048',
                'birthdate'=>'required|date',
                'btnradio'=>'required'
            ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    
    protected function create(array $data)
    {
        $instituicaoEnsino='FEUP';
        $privacidade="private";
        
        if($data['btnradio']=='public'){
            $privacidade='public';
        }

        $date = new Carbon($data['birthdate']);
        if(!(is_null($data['profile-pic']))){

            $newImageName = 'assets/img/' . time() . '-' . pathinfo($data['profile-pic']->getClientOriginalName(),PATHINFO_FILENAME) . '.' . $data['profile-pic']->extension();
            $data['profile-pic']->move(public_path('/assets/img'),$newImageName);
            $fotoPerfil = $newImageName;
        }     
            
            return User::create([
                'nome' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'datanascimento'=>$date,
                'instituicaoensino' => $instituicaoEnsino,
                'privacidade' => $privacidade,
                'fotoperfil' => $fotoPerfil
            ]);
            

    }

    public function validateUser(Request $request){ //checks if email already exists (intention at least)
        return json_encode(['status' => User::where('email', $request->get('email'))->exists()]);
    }
}