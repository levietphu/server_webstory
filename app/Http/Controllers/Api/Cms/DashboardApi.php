<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users_chuongtruyen;
use App\Models\Donate;
use App\Models\AmountReceived;
use DB;
use Log;
use Carbon\Carbon;

class DashboardApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $start_today=Carbon::now()->startOfDay();
        $end_today=Carbon::now()->endOfDay();

        $start_last_month= new Carbon('first day of last month');
        $end_last_month=new Carbon('last day of last month');

        $start_month=Carbon::now()->startOfMonth();
        $end_month=Carbon::now()->endOfMonth();

        //Doanh thu hôm nay

        $total_coin_today = 0;
        $total_coin_donate_today = 0;

        $amount_receiveds_today = AmountReceived::wherebetween("created_at",[$start_today,$end_today])->where("user_receive",$req->id_user)->get();

        $donate_today = Donate::wherebetween("created_at",[$start_today,$end_today])->where("donnor",$req->id_user)->select("coin_donate")->get();

        foreach ($amount_receiveds_today as $value) {
            $total_coin_today +=$value->money;
        }

        foreach ($donate_today as $value) {
            $total_coin_donate_today+=$value->coin_donate;
        }

        //Doanh thu tháng này
        $total_coin_month = 0;
        $total_coin_donate_month = 0;

        $amount_receiveds_month = AmountReceived::wherebetween("created_at",[$start_month,$end_month])->where("user_receive",$req->id_user)->get();

        $donate_month = Donate::wherebetween("created_at",[$start_month,$end_month])->where("donnor",$req->id_user)->select("coin_donate")->get();

        foreach ($amount_receiveds_month as $value) {
            $total_coin_month +=$value->money;
        }

        foreach ($donate_month as $value) {
            $total_coin_donate_month+=$value->coin_donate;
        }

        //Doanh thu tháng trước
        $total_coin_last_month = 0;
        $total_coin_donate_last_month = 0;

        $amount_receiveds_last_month = AmountReceived::wherebetween("created_at",[$start_last_month,$end_last_month])->where("user_receive",$req->id_user)->get();

        $donate_last_month = Donate::wherebetween("created_at",[$start_last_month,$end_last_month])->where("donnor",$req->id_user)->select("coin_donate")->get();

        foreach ($amount_receiveds_last_month as $value) {
            $total_coin_last_month +=$value->money;
        }

        foreach ($donate_last_month as $value) {
            $total_coin_donate_last_month+=$value->coin_donate;
        }

        //Số chương mua hôm nay
        $chapter_today = Users_chuongtruyen::wherebetween("created_at",[$start_today,$end_today])->select("id_user")->get();
        $count_chapter_today = [];

        foreach ($chapter_today as $value) {
            if($req->id_user == $value->id_user){
                $count_chapter_today[]=$value->id_user;
            }
        }

        //Số chương mua tháng nay
        $chapter_month = Users_chuongtruyen::wherebetween("created_at",[$start_month,$end_month])->select("id_user")->get();
        $count_chapter_month = [];
        
        foreach ($chapter_month as $value) {
            if($req->id_user == $value->id_user){
                $count_chapter_month[]=$value->id_user;
            }
        }

        //Số chương mua tháng trước
        $chapter_last_month = Users_chuongtruyen::wherebetween("created_at",[$start_last_month,$end_last_month])->select("id_user")->get();
        $count_chapter_last_month = [];
        
        foreach ($chapter_last_month as $value) {
            if($req->id_user == $value->id_user){
                $count_chapter_last_month[]=$value->id_user;
            }
        }

        return [
        	"success" => true,
        	"status" => 200,
        	"dashboard" => [
                "revenue"=>[
                    "today"=>$total_coin_today+$total_coin_donate_today,
                    "month"=>$total_coin_month+$total_coin_donate_month,
                    "last_month"=>$total_coin_last_month+$total_coin_donate_last_month,
                ],
                "donate"=>[
                    "today"=>$total_coin_donate_today,
                    "month"=>$total_coin_donate_month,
                    "last_month"=>$total_coin_donate_last_month,
                ],
                "buy_chapter" => [
                    "today"=>count($count_chapter_today),
                    "month"=>count($count_chapter_month),
                    "last_month"=>count($count_chapter_last_month),
                ]
            ]
        ];
    }

}