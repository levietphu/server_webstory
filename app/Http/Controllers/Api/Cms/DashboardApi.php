<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransitionHistory;
use App\Models\Truyen;
use DB;
use Log;

class DashboardApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $check = TransitionHistory::where("status","!=",2)->get();        
        $transaction = json_decode(json_encode($check));
        foreach ($check as $key => $value) {
            $transaction[$key]->bank_info = $value->get_bank_info()->select("id_user")->first();
        }
        return [
        	"success" => true,
        	"status" => 200,
        	"dashboard" => [
                "transaction"=>$transaction
            ]
        ];
    }

}