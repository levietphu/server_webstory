<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Truyen;
use App\Models\View;
use App\Models\User;
use App\Models\Notification;
use App\Models\NotificationObject;
use DB;
use Carbon\Carbon;

class HomeApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //banner
        $banners = Banner::join('truyens','banners.id_truyen','=','truyens.id')->where('banners.status',1)->orderby('created_at','desc')->limit(4)->get(array(DB::raw('truyens.slug as slugtruyen'),'banners.*'));

        //Thông báo
        $noti = Notification::join("notification_objects","notification_objects.id","=","notifications.id_noti_object")->where("notification_objects.type","!=",3)->orderby("notifications.created_at","desc")->select("notification_objects.*")->limit(5)->get();

       $noti_comment=[];
       $noti_donate=[];
       
       foreach ($noti as $key => $value) {
           switch ($value->type) {
               case 1:
                   $noti_comment[$key]["user"] = NotificationObject::find($value->id)->getComment()->first()->user_comment()->select("name","id")->first();
                   $noti_comment[$key]["type"] = NotificationObject::find($value->id)->type;
                   $noti_comment[$key]["story"] = NotificationObject::find($value->id)->getComment()->first()->getStory()->select("name","id")->first();
                   break;
               
                default:
                   $noti_donate[$key]["user"]= NotificationObject::find($value->id)->getDonate()->first()->getUserDonate()->select("name","id")->first();
                   $noti_donate[$key]["coin_donate"] =NotificationObject::find($value->id)->getDonate()->first()->coin_donate;
                   $noti_donate[$key]["type"]=NotificationObject::find($value->id)->type;
                   $noti_donate[$key]["story"]=NotificationObject::find($value->id)->getDonate()->first()->getStory()->select("name","id")->first();
                   break;
           }
       }
        
        //Truyện được đề xuất
        $recommendedStory = Truyen::join('theloai_truyens','theloai_truyens.id_truyen','=','truyens.id')
        ->join('theloais','theloais.id','=','theloai_truyens.id_theloai')->orderby('truyens.created_at','desc')->where("truyens.recommended",1)->where('truyens.status',1)->groupby('truyens.id')->limit(20)->get(array(DB::raw('theloais.name as nameTheloai'),'truyens.*'));

        // Sắp xếp truyện hot theo tuần
        $start_week=Carbon::now()->startOfWeek();
        $end_week=Carbon::now()->endOfWeek();

        $checkWeek=Truyen::join('views','views.id_truyen','=','truyens.id')->wherebetween('views.created_at',[$start_week,$end_week])->where('truyens.status',1)->groupBy('views.id_truyen')->orderBy(DB::raw('COUNT(views.id_truyen)'),'desc')->limit(20)->get(array(DB::raw('COUNT(views.id_truyen) as total_view'), 'truyens.*'));

        $truyenhot_sort_week = json_decode(json_encode($checkWeek));
            foreach ($checkWeek as $key => $value) {
                $truyenhot_sort_week[$key]->theloais = $value->truyen()->select('name')->first();
            }

        //bảng xếp hạng truyện vip
        $rankVip = Truyen::where("truyens.vip",1)->orderby('truyens.view_count', 'desc')->join('theloai_truyens','theloai_truyens.id_truyen','=','truyens.id')
        ->join('theloais','theloais.id','=','theloai_truyens.id_theloai')->where('truyens.status',1)->groupby('truyens.id')->limit(20)->get(array(DB::raw('theloais.name as nameTheloai'),'truyens.*'));

        //Truyện hot mới ra lò
        $hotStory = Truyen::join('theloai_truyens','theloai_truyens.id_truyen','=','truyens.id')
        ->join('theloais','theloais.id','=','theloai_truyens.id_theloai')->where("truyens.hot",1)->where('truyens.status',1)->orderby('truyens.created_at','desc')->groupby('truyens.id')->limit(20)->get(array(DB::raw('theloais.name as nameTheloai'),'truyens.*'));

        $check = Truyen::join('chuongtruyens','truyens.id','=','chuongtruyens.id_truyen')
        ->where('truyens.status',1)
        ->groupby('chuongtruyens.id_truyen')->orderby(DB::raw('max(chuongtruyens.created_at)'), 'desc')
        ->select('truyens.*')
        ->limit(20)
        ->get();

        //truyện mới cập nhật
        $newUpdateStory = json_decode(json_encode($check));
        foreach ($check as $key => $value) {
            $newUpdateStory[$key]->theloais = $value->truyen;
            $newUpdateStory[$key]->tacgia = $value->tacgia;
            $newUpdateStory[$key]->chuong = $value->chuong()->orderBy('created_at','desc')->first();
        }

        $aa = Truyen::where('full', 1)->orderby('created_at','desc')->limit(20)->get();
        
        //truyện đã hoàn thành
        $fullStory = json_decode(json_encode($aa));
        foreach ($aa as $key => $value) {
            $fullStory[$key]->theloais = $value->truyen;
        }

        return [
            'success'=>true,
            'status'=>200,
            'data'=> [
            'items' => [
                'banners'=>$banners,
                "notifications"=>array_merge($noti_comment,$noti_donate),
                'recommendedStory'=>$recommendedStory,
                'truyenhot_sort_week' => $truyenhot_sort_week,
                'rankVip'=>$rankVip,
                'hotStory'=>$hotStory,
                'newUpdateStory'=>$newUpdateStory,
                'fullStory'=>$fullStory,
                ]
        ]];
    }
    
}
