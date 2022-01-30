<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

class ContactsController extends Controller {
    
    public function show() {
        if(Auth::guard('admin')->check()){
            return view('admin.admin_contacts');
        }
        return view('pages.contacts');
    }
}