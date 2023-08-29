<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Session;
use App\Models\Visitor;

class DashboardController extends Controller
{
    public function index()
    {
        $visitor = Visitor::orderby('created_at','desc')->get();
        return view('backend.dashboard.index',compact('visitor'));
    }
    public function loginAdmin()
    {
        return view('backend.dashboard.loginAdmin');
    }   
    public function post_loginAdmin(Request $req)
    {
        $req->validate([
            'email'=>'required',
            'password'=>'required|min:8'
        ]);
        $admin = User::where('email',$req->email)->first();
       if (empty($admin)) {
           return redirect()->back()->with('error','Email không tồn tại');
       }else{
            if (Hash::check($req->password, $admin->password)) {
                Session::push('admin',$admin);
                return redirect()->route('admin');
            }else{
                return redirect()->back()->with('error','Sai mật khẩu');
            }
       }
    }
    public function logoutAdmin()
    {
        Session::forget('admin');
        return redirect()->route('loginAdmin');
    }
}
