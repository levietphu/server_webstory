<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WithdrawMoney;
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
    public function index()
    {

        $withdraw_money = WithdrawMoney::all();

        return [
        	"success" => true,
        	"status" => 200,
        	"withdraw_money" => $withdraw_money
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
                    $user = User::find($transition->id_user);
                    $user->coin = $user->coin + $req->coin;
                    $user->save();
                }

                DB::commit();
                return [
                    "success" => true,
                    "status" => 200,
                    "message" =>"Đã chuyển khoản thành công"
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
         try{
            DB::beginTransaction();

            $withdraw_money = new WithdrawMoney;
            $withdraw_money->id_user=$req->id_user;
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