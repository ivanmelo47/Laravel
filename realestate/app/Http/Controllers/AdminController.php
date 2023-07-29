<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;


use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function AdminDashboard(){

        return view('admin.index');
    }//End Method

    public function AdminLogout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login'); 
    }//End Method

    public function AdminLogin(){

        return view('admin.admin_login');
    }//End Method

    public function AdminProfile(){

        $id = Auth::user()->id;
        $prorfileData = 
    }//End Method
}
