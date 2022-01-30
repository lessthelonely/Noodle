<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller {
    
    public function show() {
        if(Auth::guard('admin')->check()){
            return view('admin.admin_faq');
        }
        return view('pages.faq');
    }
}