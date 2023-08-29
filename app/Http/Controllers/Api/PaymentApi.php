<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TransitionHistory;
use App\Models\NotificationRecipient;
use App\Models\Notification;
use App\Models\NotificationObject;
use App\Models\BankInfo;
use DB;
use Log;

class PaymentApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_transaction(Request $req)
    {

        $bank_info = BankInfo::find($req->id_bankinfo);
        try{

            DB::beginTransaction();
            if($req->image || $req->file("image")){
                $image = $req->file('image')->getClientOriginalName();  

                //upload ảnh lên thư mục      
                $req->file('image')->move('public/uploads/Transaction/', $image);
            }   

            $transition = new TransitionHistory;
            $transition->transaction_code = $req->transaction_code;
            $transition->content = $req->content;
            $transition->coin_number = $req->coin_number;
            $transition->money = $req->money;
            $transition->id_user = $req->id_user;
            $transition->id_bankinfo = $req->id_bankinfo;
            $transition->serial = $req->serial;
            $transition->code_card = $req->code_card;
            $transition->image = $req->image || $req->file("image") ?$image :$req->image;
            $transition->save();

            $noti_obj = new NotificationObject;
            $noti_obj->type = 3;
            $noti_obj->save();

            $noti = new Notification;
            $noti->id_noti_object = $noti_obj->id;
            $noti->save();

            $noti_obj->getTransition()->attach($transition->id);

            $notification_recipients = new NotificationRecipient;
            $notification_recipients->id_user = $bank_info->id_user;
            $notification_recipients->id_noti = $noti->id;
            $notification_recipients->save();

            DB::commit();
            return [
                "success" => true,
                "status" => 200,
                "message" =>"Gửi yêu cầu nạp tiền thành công"
            ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return abort(500,"Lỗi hệ thống. Vui lòng thử lại sau");
        }
    }


    public function show_transaction(Request $req)
    {
        $transaction_history = TransitionHistory::where("id_user",$req->id_user)->orderby("updated_at","desc")->paginate(10);
        return [
            "success"=>true,
            "status"=>200,
            "transaction_history"=>$transaction_history
        ];
    }
    
   
}