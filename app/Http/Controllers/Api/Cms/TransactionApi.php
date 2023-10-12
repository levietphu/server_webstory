<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransitionHistory;
use App\Models\User;
use DB;
use Log;
use Carbon\Carbon;

class TransactionApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $start_today=Carbon::now()->startOfDay();
        $end_today=Carbon::now()->endOfDay();

        $transaction = TransitionHistory::select("transition_histories.*","users.name as name_user_payment","bank_infos.type as type_bank","bank_infos.id_user as id_user_bank")
        ->join("users","transition_histories.id_user","=","users.id")
        ->join("bank_infos","bank_infos.id","=","transition_histories.id_bankinfo")
        ->wherebetween('transition_histories.created_at',[$start_today,$end_today])
        ->orderby("created_at","desc")
        ->get();

        return [
        	"success" => true,
        	"status" => 200,
        	"transaction" => $transaction
        ];
    }

     public function change_status_payment(Request $req)
    {
        try{
            if($req->status != 0){
                DB::beginTransaction();
                
                $transition = TransitionHistory::find($req->id_transaction);
                $transition->status = $req->status;
                $transition->save();

                if($req->status ==1){
                    DB::commit();
                    return [
                         "success"=>false,
                         "status"=>400,
                         "message"=>"Không được duyệt"
                     ];
                 }

                if($req->status ==2){
                    $user = User::find($transition->id_user);
                    $user->coin = $user->coin + $req->coin_number;
                    $user->save();
                }
                DB::commit();

                return [
                    "success"=>true,
                    "status"=>200,
                    "message"=>"Yêu cầu thanh toán thành công + Đã nạp xu vào tài khoản"
                ];
            }
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return abort(500,$exception->getMessage().'Line'.$exception->getLine());
        }
    }
}