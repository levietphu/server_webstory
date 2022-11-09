<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function dangky()
    {
        return view('frontend.pages.dangky');
    }
    public function post_dangky(RegisterRequest $req)
    {
        $newUser = new User;
        $newUser->email = $req->email;
        $newUser->name = $req->name;
        $newUser->password = Hash::make($req->password);
        $newUser->save();
        return redirect()->route('dangnhap');
    }
    public function dangnhap()
    {
        return view('frontend.pages.login');
    }
    public function post_dangnhap(Request $req)
    {
        $user = User::where('email',$req->email)->first();
        if (empty($user)) {
           return redirect()->back()->with('error','Email không tồn tại');
       }else{
            if (Hash::check($req->password, $user->password)) {
                Auth::login($user,$remember=true);
                return redirect()->route('home');
            }else{
                return redirect()->back()->with('error','Sai mật khẩu');
            }
        }
    }
    public function post_dangnhap_view(Request $req)
    {
        $user = User::where('email',$req->email)->first();
        if (empty($user)) {
           return redirect()->back()->with('error','Email không tồn tại');
       }else{
            if (Hash::check($req->password, $user->password)) {
                Auth::login($user,$remember=true);
                return redirect()->back();
            }else{
                return redirect()->back()->with('error','Sai mật khẩu');
            }
        }
    }
    public function dangxuat()
    {
        Auth::logout();
        return redirect()->back();
    }
}
