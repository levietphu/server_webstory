<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Users_chuongtruyen;
use App\Models\BookMark;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
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
    public function register(RegisterRequest $req)
    {

        $newUser = new User;
        $newUser->email = $req->email;
        $newUser->name = $req->name;
        $newUser->remember_token = Str::random(60);
        $newUser->password = Hash::make($req->password);
        $newUser->save();
       
        return ['success'=>true,
        'status'=>200,
        'data' => ['result'=>'Đăng ký thành công']
        ];
    }

    public function login(LoginRequest $req)
    {
        $email = $req->email;
        $password = $req->password;
        if(str_contains($email, "@")){
            $user = User::where('email',$email)->first();
        }else{
            $user = User::where("name",$email)->first();
        }

        if(!$user){
            return abort(400,"Thông tin đang nhập không chính xác");
        }

        if (!Hash::check($password, $user->password)) {
            return abort(400,'Mật khẩu không đúng');
        }
        $user->remember_token = Str::random(60);
        $user->save();


        return [
                'success'=>true,
                'status'=>200,
                'data' => ['result' => 'Đăng nhập thành công','token'=>$user->remember_token]
            ]; 
    
    }

    public function getUser(Request $req)
    {

        $token = is_null($req->bearerToken()) ? $req->token:$req->bearerToken();
       $user = User::where('remember_token', $token)->select('id','name','email','coin')->first();

        if(!$user){
            return abort(401);
        }

        $check = $user->getRole()->select("roles.name","roles.id")->get();
        $role = json_decode(json_encode($check));
        foreach ($check as $key => $value) {
            $role[$key]->per=$value->getPer()->select("permissions.slug")->get();
        }

        $user_chapter = BookMark::where('id_user',$user->id)->orderby('created_at','desc')->get()->unique('id_truyen');

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
            'vipbuy'=>$vipbuy,
            'role'=>$role
           ]
        ]
            
        ];


    }
    public function add_coin(Request $req)
    {
        if($req->id_user){
            $user = User::find($req->id_user);
            $user->coin = $user->coin + $req->coin;
            $user->save();
            return [
                "success"=>true,
                "status"=>200,
                "message"=>"Thêm coin cho user thành công"
            ];
        }
        return abort(500);
    }
}