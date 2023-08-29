<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users_chuongtruyen;
use App\Models\Donate;
use App\Models\AmountReceived;
use App\Models\WithdrawMoney;
use App\Models\Truyen;
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

        //duyệt giao dịch rút tiền
        $withdraw_money = WithdrawMoney::join("users","users.id","=","withdraw_money.id_user")->join("affiliated_banks","affiliated_banks.id","=","withdraw_money.id_affiliatedbank")->wherebetween("withdraw_money.created_at",[$start_month,$end_month])->orderby("withdraw_money.created_at","desc")->select("withdraw_money.*","users.name","affiliated_banks.name_bank","affiliated_banks.stk","affiliated_banks.owner_account")->get();

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
        $count_chapter_today = Users_chuongtruyen::where("id_user",$req->id_user)->wherebetween("created_at",[$start_today,$end_today])->count();

        //Số chương mua tháng nay
        $count_chapter_month = Users_chuongtruyen::where("id_user",$req->id_user)->wherebetween("created_at",[$start_month,$end_month])->count();
       
        //Số chương mua tháng trước
        $count_chapter_last_month = Users_chuongtruyen::where("id_user",$req->id_user)->wherebetween("created_at",[$start_last_month,$end_last_month])->count();
        
        //Rút tiền
        $withdraw_money_success = WithdrawMoney::where("id_user",$req->id_user)->where("status",2)->count();//đã rút
        $withdraw_money_waiting = WithdrawMoney::where("id_user",$req->id_user)->where("status",0)->count();//đang chờ duyệt

        //Số truyện đã được trả tiền
        $total_story = Users_chuongtruyen::join('truyens',"truyens.id","=","users_chuongtruyens.id_truyen")->where("truyens.id_user",$req->id_user)->groupby("users_chuongtruyens.id_truyen")->get()->count();

        return [
        	"success" => true,
        	"status" => 200,
        	"dashboard" => [
                "all_withdraw_money" =>$withdraw_money,
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
                    "today"=>$count_chapter_today,
                    "month"=>$count_chapter_month,
                    "last_month"=>$count_chapter_last_month,
                ],
                "withdraw_money_success"=>$withdraw_money_success,
                "withdraw_money_waiting"=>$withdraw_money_waiting,
                "total_story"=>$total_story,
            ]
        ];
    }
    
    public function get_story_dashboard(Request $req)
    {
     
    $story_user = Users_chuongtruyen::join('truyens',"truyens.id","=","users_chuongtruyens.id_truyen")->join("tacgias","tacgias.id","=","truyens.id_tacgia")->join("translators","translators.id","=","truyens.id_trans")->where("truyens.id_user",$req->id_user)->select("truyens.*",DB::raw("tacgias.name as name_author"),DB::raw("translators.name as name_trans"))->groupby("users_chuongtruyens.id_truyen")->paginate(5);

     return [
        "success"=>true,
        "status"=>200,
        "story_user"=>$story_user,
     ];
    }
}