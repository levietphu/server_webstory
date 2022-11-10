<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Users_chuongtruyen;
use Hash;
use Str;
use DB;

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

        $token = is_null($req->bearerToken()) ? $req->token:$req->bearerToken();

       $user = User::where('remember_token', $token)->select('id','name','email','coin')->first() ;

        if(!$user){
            return abort(401);
        }
        $user_chapter = Users_chuongtruyen::where('id_user',$user->id)->orderby('created_at','desc')->get()->unique('id_truyen');

        $bookcase = json_decode(json_encode($user_chapter),true);
        foreach ($user_chapter as $key=> $value) {
            $bookcase[$key]['chuong']= $value->chuongs;
            $bookcase[$key]['truyen']= $value->truyen_user;
        }
        
        $checkVipBuy = Users_chuongtruyen::where('id_user',$user->id)->groupby('id_truyen')->where("bought",1)->get();

        $vipbuy = json_decode(json_encode($checkVipBuy));
        foreach ($checkVipBuy as $key => $value) {
            $vipbuy[$key]->truyen= $value->truyen_user()->join('theloai_truyens','theloai_truyens.id_truyen','=','truyens.id')
        ->join('theloais','theloais.id','=','theloai_truyens.id_theloai')->select('truyens.*',DB::raw('theloais.name as nameTheloai'))->first();
        }


        return ['success'=>true,'status'=>200,'data' => [
           'items'=>[
            'user'=>$user,
            'bookcase'=>$bookcase,
            'vipbuy'=>$vipbuy
           ]
        ]
            
        ];


    }
}