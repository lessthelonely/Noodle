<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class SobreNosController extends Controller {
    
    public function show() {
        if(Auth::guard('admin')->check()){
            return view('admin.admin_sobreNos');
        }
        return view('pages.sobreNos');
    }
}