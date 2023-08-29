<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use App\Models\NotificationObject;
use Str;
use DB;

class NotificationApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
       $noti = Notification::join("notification_objects","notification_objects.id","=","notifications.id_noti_object")->join('notification_recipients',"id_noti","=","notifications.id")->where("notification_recipients.id_user",$req->id_user)->where("notification_objects.type",3)->orderby("notifications.created_at","desc")->select("notification_objects.*")->paginate(5);

       $noti_loadcents=json_decode(json_encode($noti));
       
       foreach ($noti as $key => $value) {
            $noti_loadcents->data[$key]->user_loadcent= NotificationObject::find($value->id)->getTransition()->first()->getUser;
           $noti_loadcents->data[$key]->transition =NotificationObject::find($value->id)->getTransition()->first();
       }
      
        return [
            "success"=>true,
            "status"=>200,
            "noti_loadcents"=>$noti_loadcents
        ];
    }
}