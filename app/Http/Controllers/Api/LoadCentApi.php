<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoadCent;
use App\Models\BankInfo;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use DB;

class LoadCentApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function info(Request $req)
    {
        $check1=BankInfo::where('type',0)->get();
        $bank_info = json_decode(json_encode($check1));
        foreach ($check1 as $key => $value) {
            $bank_info[$key]->loadcents = $value->getLoadCent()->get();
        }
        $check2=BankInfo::where('type',1)->get();
        $wallet_info = json_decode(json_encode($check2));
        foreach ($check2 as $key => $value) {
            $wallet_info[$key]->loadcents = $value->getLoadCent()->get();
        }
        $check3=BankInfo::where('type',2)->get();
        $card = json_decode(json_encode($check3));
        foreach ($check3 as $key => $value) {
            $card[$key]->loadcents = $value->getLoadCent()->get();
        }

        return [
            "success"=>true,
            "status"=>200,
            "bank_info"=>$bank_info,
            "wallet_info"=>$wallet_info,
            "card"=>$card,
        ];
    }
}