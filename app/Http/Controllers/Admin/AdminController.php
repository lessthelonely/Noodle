<?php

//https://laravel.com/docs/4.2/queries

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

use App\Models\Administrador;
use App\Models\User;

class AdminController extends Controller
{
    public function view(){
      if(!Auth::guard('admin')->check()) return redirect('/admin-login');

      $users = User::all()->sortBy('nome');

      return view('admin.admin_view_user',['users'=>$users]);
    }

    public function banUser($id){
      if(!Auth::guard('admin')->check()) return redirect('/login');
      $user = User::find($id);
      if(is_null($user))
           return view('layouts.error204');
      
      $user->is_banned=true;
      $user->save();

      return response()->json(["Ok" => "User banned"]);
    }

    public function unbanUser($id){ 
      if(!Auth::guard('admin')->check()) return redirect('/login');
      $user = User::find($id);
      if(is_null($user))
           return view('layouts.error204');
      
      $user->is_banned=false;
      $user->save();

      return response()->json(["Ok" => "User banned"]);
    }

    public function deleteUser($id){
      if(!Auth::guard('admin')->check()) return redirect('/login');
      $user = User::find($id);
      if(is_null($user))
         return view('layouts.error204');
      $user->delete(); //Don't have to do it directly on utilizadorEstudante and utilizadorDocente because of the DELETE ON CASCADE
      return response()->json(["Ok" => "User deleted"]);
    }
}
