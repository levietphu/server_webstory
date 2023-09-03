<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use App\Models\NotificationObject;
use App\Models\NotificationRecipient;
use Str;
use DB;
use Log;

class NotificationApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
       $noti = Notification::join("notification_objects","notification_objects.id","=","notifications.id_noti_object")->join('notification_recipients',"notification_recipients.id_noti","=","notifications.id")->join("users","users.id","=","notification_recipients.id_user")->where("notification_recipients.id_user",$req->id_user)->where("notification_objects.type",3)->orderby("notifications.created_at","desc")->select("notification_objects.*","notification_recipients.id as id_repcipients","notification_recipients.is_read")->paginate(5);

       $noti_count = Notification::join("notification_objects","notification_objects.id","=","notifications.id_noti_object")->join('notification_recipients',"notification_recipients.id_noti","=","notifications.id")->join("users","users.id","=","notification_recipients.id_user")->where("notification_recipients.id_user",$req->id_user)->where("notifications.is_view",0)->where("notification_objects.type",3)->orderby("notifications.created_at","desc")->get()->count();

       $noti_loadcents=json_decode(json_encode($noti));
       
       foreach ($noti as $key => $value) {
            $noti_loadcents->data[$key]->user_loadcent= NotificationObject::find($value->id)->getTransition()->first()->getUser;
           $noti_loadcents->data[$key]->transition =NotificationObject::find($value->id)->getTransition()->first();
       }

      
        return [
            "success"=>true,
            "status"=>200,
            "noti_loadcents"=>$noti_loadcents,
            "noti_count"=>$noti_count
        ];
    }

    public function change_is_read(Request $req)
    {
        try{
            DB::beginTransaction();

            $notification_recipients = NotificationRecipient::find($req->id);
            $notification_recipients->is_read = 1;
            $notification_recipients->save();

            DB::commit();
            return [
                "success"=>true,
                "status"=>200,
                "message"=>"thành công"
            ];
            
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return abort(500);
        }
    }

    public function change_is_view(Request $req)
    {
        try{
            DB::beginTransaction();

            $notification = Notification::join('notification_recipients',"notification_recipients.id_noti","=","notifications.id")->join("users","users.id","=","notification_recipients.id_user")->where("notification_recipients.id_user",$req->id_user)->where("notifications.is_view",0)->select("notifications.*")->get();

            foreach ($notification as $value) {
                $value->is_view = 1;
                $value->save();
            }

            DB::commit();
            return [
                "success"=>true,
                "status"=>200,
                "message"=>"thành công"
            ];
            
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return abort(500);
        }
    }
}