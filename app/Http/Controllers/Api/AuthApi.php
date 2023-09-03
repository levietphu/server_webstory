<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Users_chuongtruyen;
use App\Models\LoginHistory;
use App\Models\BookMark;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpForgotPass;
use Hash;
use Str;
use DB;
use Log;
use Carbon\Carbon;
use \Jenssegers\Agent\Agent;

class AuthApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $req)
    {
       try{
        DB::beginTransaction();

        $newUser = new User;
        $newUser->email = $req->email;
        $newUser->name = $req->name;
        $newUser->remember_token = Str::random(60);
        $newUser->password = Hash::make($req->password);
        $newUser->save();

        DB::commit();
        return ['success'=>true,
            'status'=>200,
            'data' => ['result'=>'Đăng ký thành công']
        ];
    }catch(\Exception $exception){
        DB::rollback();
        Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
        return abort(500,"Đăng ký thất bại");
    }
}

public function login(LoginRequest $req)
{
    $email = $req->email;
    $password = $req->password;
    $agent = new Agent;
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

     try{
        DB::beginTransaction();

        $user->remember_token = Str::random(60);
        $user->save();

        $login_history = new LoginHistory;
        $login_history->id_user = $user->id;
        $login_history->browser = $agent->browser();
        $login_history->browser_version = $agent->version($agent->browser());
        $login_history->platform = $agent->platform();
        $login_history->ip_address = $req->ip();
        $login_history->save();

        DB::commit();

        return [
            'success'=>true,
            'status'=>200,
            'data' => ['result' => 'Đăng nhập thành công','token'=>$user->remember_token]
        ]; 
    }catch(\Exception $exception){
        DB::rollback();
        Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
        return abort(500);
    }   
    


    
    
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

public function forgot(Request $req)
{
   $user = User::where("email",$req->email)->first();
   if(!$user){
        return abort(400,"Không tìm thấy tài khoản này");
    }
    try{
        DB::beginTransaction();

        $user->otp = rand(00000000,1000000);
        $user->before_expired_time=Carbon::now();
        $user->check_otp = 5;
        $user->save();

        Mail::to($req->email)->send(new OtpForgotPass($user));

        DB::commit();

        return [
            "success"=>true,
            "status"=>200,
            "message"=>"Mã xác nhận đã được gửi về email của bạn.",
            "id_check_user" =>$user->id
        ];
    }catch(\Exception $exception){
        DB::rollback();
        Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
        return abort(500);
    }   
}

public function check_otp(Request $req)
{
    $user = User::find($req->id);
    $now=Carbon::now();

    if($user->check_otp ==0){
        return abort(400,"Bạn đã hết số lần thử");
    }

    if($user->otp != $req->otp){
        $user->check_otp = $user->check_otp-1;
        $user->save();
        return abort(400,"Sai OTP. Bạn còn lại ".($user->check_otp)." lần nữa để thử lại");
    }

    if($now->diffInMinutes($user->before_expired_time)>5){
        return abort(400,"Mã OTP đã hết hạn");
    }

    return [
        "success"=>true,
        "status"=>200,
        "user_reset_password" => $user
    ];
}

public function change_pass(Request $req)
{
    
    $user = User::find($req->id);
    $user->password = Hash::make($req->password);
    $user->save();

    return [
        "success"=>true,
        "status"=>200,
        "message"=>"Thay đổi mật khẩu thành công. Vui lòng đăng nhập lại!"
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