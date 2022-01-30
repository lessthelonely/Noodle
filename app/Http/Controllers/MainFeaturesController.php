<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class MainFeaturesController extends Controller {
    
    public function show() {
        if(Auth::guard('admin')->check()){
            return view('admin.admin_mainfeatures');
        }
        return view('pages.mainfeatures');
    }
}