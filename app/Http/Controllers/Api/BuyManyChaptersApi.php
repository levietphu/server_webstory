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

class BuyManyChaptersApi extends Controller
{
    public function create(Request $req)
    {
        // $user = User::find($req->id_user);
        // if(!$user){
        //     return abort(400,"Không tồn tại người dùng");
        // }


        $toCoin = 1;
        $fromCoin = 33;
        $totalCoin = 0;

        // if($fromCoin > count($check)){
        //     return abort(400,"số chương truyện phải nhỏ hơn".count($check));
        // }
        
        //lấy ra tất cả chương truyện mất phí
        $check = Chuongtruyen::where("id_truyen",1)->where('coin','>',0)->get();
        // $user_posted=User::find(Truyen::find($req->id_truyen)->id_user);

        //lấy ra chương truyện mà user đã mua
        $check_bought=Users_chuongtruyen::where("id_truyen",1)->where("id_user",11)->where("bought",1)->get();
        $id_bought= [];
        foreach ($check_bought as $value) {
            $id_bought[] = $value->id_chuong;
        }
        
        foreach ($check as $key => $value) {
            if(explode("-",$value->slug)[1] <=$fromCoin && $toCoin<= explode("-",$value->slug)[1]){
                if(!in_array($value->id,$id_bought)){
                    $totalCoin+=$value->coin;

                    // $user_many_chapter = new Users_chuongtruyen;
                    // $user_many_chapter->id_chuong=$value->id;
                    // $user_many_chapter->id_user=11;
                    // $user_many_chapter->bought=1;
                    // $user_many_chapter->id_truyen=1;
                    // $user_many_chapter->buy_many=1;
                    // $user_many_chapter->save();
                }
            } 
        }
        // if($req->id_user==Truyen::find($req->id_truyen)->id_user){
        //    return [
        //     "success"=>true,
        //     "status"=>200,
        //     "message"=>"Là dịch giả nên không mất xu"
        //    ];
        // }
        // if($user->coin <= $totalCoin){
        //     return abort(400,"Vui lòng nạp xu thêm để mua lại");
        // }

        $discount = Discount::where("id_truyen",1)->get();
        if(count($discount)>0){
            foreach ($discount as $value) {
                if(($fromCoin - $toCoin) >= $value->number_chapter){
                    $totalCoin = (int)round($totalCoin - ($totalCoin * ($value->value)/100));
                }
            }
        }
        
        dd($totalCoin);
        // $user->coin = $user->coin - $totalCoin;
        // $user->save();
        
        // $user_posted->coin = $user_posted->coin + $totalCoin;
        // $user_posted->save();
        // return [
        //     "success"=>true,
        //     "status"=>200,
        //     "message"=>"Mua nhiều chương truyện thành công"
        // ];
    }
}