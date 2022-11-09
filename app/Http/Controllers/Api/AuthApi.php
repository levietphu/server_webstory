<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Str;

class AuthApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $req)
    {
        $name = $req->name;
        $email = $req->email;
        $password = $req->password;

        $user = User::where('email',$email)->first();

        if($user){
            return [
                'success'=>false,
                'status'=>401,
                'data' => ['hasMore' => 'Người dùng đã tồn tại']
            ];
        }
        if(strlen ($password)<8){
return [
                'success'=>false,
                'status'=>401,
                'data' => ['hasMore' => 'Mật khẩu ít hơn 8 ký tự']
            ];
        }
        


        $newUser = new User;
        $newUser->email = $req->email;
        $newUser->name = $req->name;
        $newUser->remember_token = Str::random(60);
        $newUser->password = Hash::make($req->password);
        $newUser->save();
       
        return ['success'=>true,
        'status'=>200,
        'data' => ['result'=>'Đăng ký thành công','token'=>$newUser->remember_token]
        ];
    }

    public function login(Request $req)
    {
        $email = $req->email;
        $password = $req->password;

        $user = User::where('email',$email)->first();

        if(!$user){
            return [
                'success'=>false,
                'status'=>401,
                'data' => ['hasMore' => 'Email or password wrong']
            ];
        }

        if (!Hash::check($password, $user->password)) {
            return [
                'success'=>false,
                'status'=>401,
                'data' => ['hasMore' => 'Email or password wrong']
            ];
        }

        return [
                'success'=>true,
                'status'=>200,
                'data' => ['result' => 'Đăng nhập thành công','token'=>$user->remember_token]
            ]; 
    
    }

    public function getUser(Request $req)
    {

        $token = $req->bearerToken();

        $user = User::where('remember_token', $token)->select('name','email','coin')->first();

        if(!user){
            return [
                'success'=>true,
                'status'=>401,
                'data'=> ['hasMore'=>'Unauthorized']
            ];
        }

        return [
            'success'=>true,
            'status'=>200,
            'data'=> [
                'user'=> $user]
        ];
    }
}