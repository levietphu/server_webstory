<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chuongtruyen;
use App\Models\Truyen;
use App\Models\Users_chuongtruyen;
use App\Models\Discount;
use App\Http\Requests\BuyManyChapterRequest;
use DB;
use Carbon\Carbon;

class BuyManyChaptersApi extends Controller
{
    public function create(BuyManyChapterRequest $req)
    {
        $user = User::find($req->id_user);

        $toChapter = $req->toChapter;
        $fromChapter = $req->fromChapter;
        $totalCoin = 0;
        
        //lấy ra tất cả chương truyện mất phí
        $check = Chuongtruyen::where("id_truyen",$req->id_truyen)->where('coin','>',0)->get();

        //tổng số chương truyện
        $totalChapter = Chuongtruyen::where("id_truyen",$req->id_truyen)->count();

        $user_posted=User::find(Truyen::find($req->id_truyen)->id_user);

        //lấy ra chương truyện mà user đã mua
        $check_bought=Users_chuongtruyen::where("id_truyen",$req->id_truyen)->where("id_user",$req->id_user)->where("bought",1)->get();
        $id_bought= [];

        if(count($check_bought)>0){
            foreach ($check_bought as $value) {
                $id_bought[] = $value->id_chuong;
            }
        }

        $chapter_will_buy= [];
        foreach ($check as $key => $value) {
            if(explode("-",$value->slug)[1] <=$fromChapter && $toChapter<= explode("-",$value->slug)[1]){
                if(!in_array($value->id,$id_bought)){
                    $totalCoin+=$value->coin;
                    $chapter_will_buy[]=$value;
                    try{
                        DB::beginTransaction();
                        $user_many_chapter = new Users_chuongtruyen;
                        $user_many_chapter->id_chuong=$value->id;
                        $user_many_chapter->id_user=$req->id_user;
                        $user_many_chapter->bought=1;
                        $user_many_chapter->id_truyen=$req->id_truyen;
                        $user_many_chapter->buy_many=1;
                        $user_many_chapter->save();
                        DB::commit();
                    }catch(\Exception $exception){
                        DB::rollback();
                        return abort(500);
                    }
                }
            } 
        }

        $discount = Discount::where("id_truyen",$req->id_truyen)->get();
        $minus = [];
        $sale=0;

        //check giảm giá
        if(count($discount)>0){
            foreach ($discount as $value) {
                if(count($chapter_will_buy) >= $value->number_chapter){
                    $minus[] = $value;
                }
            }
            if(count($minus)>0){
                $sale=(int)round($totalCoin*$minus[count($minus)-1]->value/100);
            }
        }

        
        $reduceCoin=$totalCoin-$sale;

        if($req->id_user == $user_posted->id){
            return [
                "success"=>true,
                "status"=>200,
                "remaining_coins"=>$user->coin
            ];
        }   
       
        $user->coin = $user->coin - $reduceCoin;
        $user->save();
        
        $user_posted->coin = $user_posted->coin + $reduceCoin;
        $user_posted->save();
        return [
            "success"=>true,
            "status"=>200,
            "remaining_coins"=>$user->coin
        ];
    }
    public function check_price(BuyManyChapterRequest $req)
    {
        $user = User::find($req->id_user);
        if(!$user){
            return abort(400,"Không tồn tại người dùng");
        }

        $toChapter = $req->toChapter;
        $fromChapter = $req->fromChapter;
        $totalCoin = 0;

        if($fromChapter <= $toChapter){
            return abort(400,"Khoảng chương không hợp lệ");
        }

        //lấy ra tất cả chương truyện mất phí
        $check = Chuongtruyen::where("id_truyen",$req->id_truyen)->where('coin','>',0)->get();

        //tổng số chương truyện
        $totalChapter = Chuongtruyen::where("id_truyen",$req->id_truyen)->count();

        if($fromChapter > $totalChapter){
            return abort(400,"Số chương truyện phải nhỏ hơn hoặc bằng".$totalChapter."chương");
        }

        $user_posted=User::find(Truyen::find($req->id_truyen)->id_user);

        //lấy ra chương truyện mà user đã mua
        $check_bought=Users_chuongtruyen::where("id_truyen",$req->id_truyen)->where("id_user",$req->id_user)->where("bought",1)->get();
        $id_bought= [];

        if(count($check_bought)>0){
            foreach ($check_bought as $value) {
                $id_bought[] = $value->id_chuong;
            }
        }

        $chapter_will_buy= [];
        foreach ($check as $key => $value) {
            if(explode("-",$value->slug)[1] <=$fromChapter && $toChapter<= explode("-",$value->slug)[1]){
                if(!in_array($value->id,$id_bought)){
                    $totalCoin+=$value->coin;
                    $chapter_will_buy[]=$value;
                }
            } 
        }
        if(count($chapter_will_buy)==0){
            return abort(400,"Trong khoảng này không có chương vip để mua");
        }

        $discount = Discount::where("id_truyen",$req->id_truyen)->get();
        $minus = [];
        $sale=0;

        //check giảm giá
        if(count($discount)>0){
            foreach ($discount as $value) {
                if(count($chapter_will_buy) >= $value->number_chapter){
                    $minus[] = $value;
                }
            }
            if(count($minus)>0){
                $sale=(int)round($totalCoin*$minus[count($minus)-1]->value/100);
            }
        }
        $reduceCoin=$totalCoin-$sale;
        
        //check dịch giả đăng truyện không mất xu
        if($req->id_user==Truyen::find($req->id_truyen)->id_user){
           return [
                "success"=>true,
                "status"=>200,
                "data"=>[
                    "toChapter"=>$chapter_will_buy[0]->chapter_number,
                    "fromChapter"=>$chapter_will_buy[count($chapter_will_buy)-1]->chapter_number,
                    "totalChapter"=>count($chapter_will_buy),
                    "totalCoin"=>$totalCoin,
                    "sale"=>$sale,
                    "discount_percent"=>count($minus)>0 ? $minus[count($minus)-1]->value:0,
                    "discount_chapter"=>count($minus)>0?$minus[count($minus)-1]->number_chapter:0,
                    "payment"=>0,
                    "message"=> "Dịch giả không mất xu, Vui lòng xác nhận thanh toán",
                ]
            ];
        }

        //check khi không đủ tiền thanh toán
        if($user->coin < $totalCoin){
            return [
                "success"=>false,
                "status"=>400,
                "data"=>[
                    "toChapter"=>$chapter_will_buy[0]->chapter_number,
                    "fromChapter"=>$chapter_will_buy[count($chapter_will_buy)-1]->chapter_number,
                    "totalChapter"=>count($chapter_will_buy),
                    "totalCoin"=>$totalCoin,
                    "sale"=>$sale,
                    "discount_percent"=>count($minus)>0 ? $minus[count($minus)-1]->value:0,
                    "discount_chapter"=>count($minus)>0?$minus[count($minus)-1]->number_chapter:0,
                    "payment"=>$reduceCoin,
                    "message"=> "Bạn không đủ XU để thanh toán vui lòng nạp thêm",
                ]
            ];
        }

        return [
            "success"=>true,
            "status"=>200,
            "data"=>[
                    "toChapter"=>$chapter_will_buy[0]->chapter_number,
                    "fromChapter"=>$chapter_will_buy[count($chapter_will_buy)-1]->chapter_number,
                    "totalChapter"=>count($chapter_will_buy),
                    "totalCoin"=>$totalCoin,
                    "sale"=>$sale,
                    "discount_percent"=>count($minus)>0 ? $minus[count($minus)-1]->value:0,
                    "discount_chapter"=>count($minus)>0?$minus[count($minus)-1]->number_chapter:0,
                    "payment"=>$reduceCoin,
                    "message"=> "Số xu của bạn đủ để thanh toán",
                ]
        ];
    }
}