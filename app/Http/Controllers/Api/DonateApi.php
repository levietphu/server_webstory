<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Donate;
use App\Models\Truyen;
use App\Models\NotificationObject;
use App\Models\Notification;
use DB;
use Log;

class DonateApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
       $donates = Donate::join("users","users.id","=","donates.user_donate")->orderby("donates.created_at","desc")->where("donates.id_truyen",Truyen::where("slug",$req->slug)->first()->id)->select("donates.*","users.name as name_user_donate")->paginate(1);
       
       $totalDonate = Donate::where('id_truyen',Truyen::where("slug",$req->slug)->first()->id)->count();
        return ['success'=>true,
                'status'=>200,
                'donates' => $donates,
                "totalDonate"=> $totalDonate
                ];
    }

    public function add_donate(Request $req)
    {
        $user_donate = User::find($req->id_user);
        $truyen = Truyen::find($req->id_truyen);

        if($user_donate->coin < $req->coin_donate){
            return abort(400,"Vui lòng nạp thêm xu");
        }
        if($req->id_user == $truyen->id_user){
            return abort(400, "Không thể tự donate cho chính mình");
        }
        try{
            DB::beginTransaction();

            $donate = new Donate;
            $donate->coin_donate = $req->coin_donate;
            $donate->user_donate = $req->id_user;
            $donate->message = $req->message;
            $donate->id_truyen = $req->id_truyen;
            $donate->donnor = $truyen->id_user;
            $donate->save();

            $user = User::find(Truyen::find($req->id_truyen)->id_user);
            $user->coin = $user->coin + $req->coin_donate;
            $user->save();

            $user_donate->coin = $user_donate->coin - $req->coin_donate;
            $user_donate->save();

            $noti_obj = new NotificationObject;
            $noti_obj->type = 2;
            $noti_obj->save();

            $noti = new Notification;
            $noti->id_noti_object = $noti_obj->id;
            $noti->save();

            $noti_obj->getDonate()->attach($donate->id);

            DB::commit();
            return [
                "success" => true,
                "status" => 200,
                "remaining_coins" =>$user_donate->coin,
            ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            
            return abort(500, "Lỗi hệ thống");    
        }
    }
   
}