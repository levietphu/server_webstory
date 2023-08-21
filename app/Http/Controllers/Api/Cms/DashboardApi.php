<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransitionHistory;
use App\Models\Users_chuongtruyen;
use App\Models\Donate;
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

        $transaction = TransitionHistory::select("transition_histories.*","users.name as name_user_payment","bank_infos.type as type_bank","bank_infos.id_user as id_user_bank")
        ->join("users","transition_histories.id_user","=","users.id")
        ->join("bank_infos","bank_infos.id","=","transition_histories.id_bankinfo")
        ->wherebetween('transition_histories.created_at',[$start_today,$end_today])
        ->get();

        //Doanh thu hôm nay

        $total_coin_today = 0;
        $total_coin_donate_today = 0;

        $revenue_to_day = Users_chuongtruyen::wherebetween("users_chuongtruyens.created_at",[$start_today,$end_today])->join("truyens","users_chuongtruyens.id_truyen","=","truyens.id")
        ->join("chuongtruyens","chuongtruyens.id","=","users_chuongtruyens.id_chuong")->select("truyens.id_user","chuongtruyens.coin")->get();

        $donate_today = Donate::wherebetween("created_at",[$start_today,$end_today])->select("coin_donate","donnor")->get();

        foreach ($revenue_to_day as $value) {
            if($req->id_user == $value->id_user){
                $total_coin_today+=$value->coin;
            }
        }

        foreach ($donate_today as $value) {
            if($req->id_user == $value->donnor){
                $total_coin_donate_today+=$value->coin_donate;
            }
        }

        //Doanh thu tháng này
        $total_coin_month = 0;
        $total_coin_donate_month = 0;

        $revenue_month = Users_chuongtruyen::wherebetween("users_chuongtruyens.created_at",[$start_month,$end_month])->join("truyens","users_chuongtruyens.id_truyen","=","truyens.id")
        ->join("chuongtruyens","chuongtruyens.id","=","users_chuongtruyens.id_chuong")->select("truyens.id_user","chuongtruyens.coin")->get();
        
        $donate_month = Donate::wherebetween("created_at",[$start_month,$end_month])->select("coin_donate","donnor")->get();

        foreach ($revenue_month as $value) {
            if($req->id_user == $value->id_user){
                $total_coin_month+=$value->coin;
            }
        }

        foreach ($donate_month as $value) {
            if($req->id_user == $value->donnor){
                $total_coin_donate_month+=$value->coin_donate;
            }
        }

        //Doanh thu tháng trước
        $total_coin_last_month = 0;
        $total_coin_donate_last_month = 0;

        $revenue_last_month = Users_chuongtruyen::wherebetween("users_chuongtruyens.created_at",[$start_last_month,$end_last_month])->join("truyens","users_chuongtruyens.id_truyen","=","truyens.id")
        ->join("chuongtruyens","chuongtruyens.id","=","users_chuongtruyens.id_chuong")->select("truyens.id_user","chuongtruyens.coin")->get();

        $donate_last_month = Donate::wherebetween("created_at",[$start_last_month,$end_last_month])->select("coin_donate","donnor")->get();

        foreach ($revenue_last_month as $value) {
            if($req->id_user == $value->id_user){
                $total_coin_last_month+=$value->coin;
            }
        }

         foreach ($donate_last_month as $value) {
            if($req->id_user == $value->donnor){
                $total_coin_donate_month+=$value->coin_donate;
            }
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
                "transaction"=>$transaction,
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