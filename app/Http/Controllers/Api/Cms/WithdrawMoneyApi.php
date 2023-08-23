<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WithdrawMoney;
use App\Models\AffiliatedBank;
use App\Models\User;
use DB;
use Log;

class WithdrawMoneyApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {

        $withdraw_money = WithdrawMoney::where("id_user",$req->id_user)->get();
        $affiliated_banks = AffiliatedBank::where("id_user",$req->id_user)->get();

        return [
        	"success" => true,
        	"status" => 200,
        	"withdraw_money" => $withdraw_money,
            "affiliated_banks" => $affiliated_banks
        ];
    }

    public function accept_withdraw_money(Request $req)
    {
        try{
            if($req->status != 0){
                DB::beginTransaction();
                $withdraw_money = WithdrawMoney::find($req->id);
                $withdraw_money->status = $req->status;
                $withdraw_money->save();

                if($req->status ==1){
                    DB::commit();
                    return [
                         "success"=>false,
                         "status"=>400,
                         "message"=>"Yêu cầu không được duyệt"
                     ];
                 }

                 if($req->status ==2){
                    $user = User::find($withdraw_money->id_user);
                    $user->coin = $user->coin - $withdraw_money->coin;
                    $user->save();
                }

                DB::commit();
                return [
                    "success" => true,
                    "status" => 200,
                    "message" =>"Lệnh đã được duyệt + chuyển khoản cho người tạo"
                ];
            }
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return abort(500,$exception->getMessage().'Line'.$exception->getLine());
        }
    }

    public function create(Request $req)
    {
        $user = User::find($req->id_user);
        if($req->coin > $user->coin){
            return abort(400,"Số xu không đủ để rút");
        }
         try{
            DB::beginTransaction();

            $withdraw_money = new WithdrawMoney;
            $withdraw_money->id_user=$req->id_user;
            $withdraw_money->id_affiliatedbank=$req->id_affiliatedbank;
            $withdraw_money->transaction_code=$req->transaction_code;
            $withdraw_money->coin=$req->coin;
            $withdraw_money->money=$req->money;
            $withdraw_money->save();

            DB::commit();
            return [
                "success" => true,
                "status" => 200,
                "message" =>"Tạo lệnh rút tiền thành công"
            ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return abort(500,$exception->getMessage().'Line'.$exception->getLine());
        }
    }
}