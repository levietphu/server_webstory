<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truyen;
use App\Models\User;
use App\Models\Chuongtruyen;
use App\Models\Users_chuongtruyen;
use DB;

class PersonalApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $user = User::find($req->id_user)->select('name','email','coin')->first();

        $user_chapter = Users_chuongtruyen::where('id_user',$req->id_user)->orderby('created_at','desc')->get()->unique('id_truyen');

        $bookcase = json_decode(json_encode($user_chapter),true);
        foreach ($user_chapter as $key=> $value) {
            $bookcase[$key]['chuong']= $value->chuongs;
            $bookcase[$key]['truyen']= $value->truyen_user;
        }
        
        $checkVipBuy = Users_chuongtruyen::where('id_user',$req->id_user)->groupby('id_truyen')->get();

        $vipbuy = json_decode(json_encode($checkVipBuy));
        foreach ($checkVipBuy as $key => $value) {
            $vipbuy[$key]->truyen= $value->truyen_user()->join('theloai_truyens','theloai_truyens.id_truyen','=','truyens.id')
        ->join('theloais','theloais.id','=','theloai_truyens.id_theloai')->select('truyens.*',DB::raw('theloais.name as nameTheloai'))->first();
        }

        return ['success'=>true,'status'=>200,'data' => [
           'items'=>[
            'user'=>$user,
            'bookcase'=>$bookcase,
            'vipbuy'=>$vipbuy
           ]
        ]
            
        ];
    }
    
}
