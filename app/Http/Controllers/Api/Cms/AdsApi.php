<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use App\Http\Requests\AddAdsRequest;
use App\Http\Requests\UpdateAdsRequest;
use DB;
use Log;

class AdsApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = Config::where('type',2)->where('status',1)->orderby("created_at","desc")->get();
        return [
        	"success" => true,
        	"status" => 200,
        	"ads" => $ads
        ];
    }
    public function create(AddAdsRequest $req)
    {

        try{
            DB::beginTransaction();
            $ads = new Config;
            $ads->name= $req->name;
            $ads->slug= $req->slug;
            $ads->type= 2;
            $ads->value= $req->value;
            $ads->status= $req->status;
            $ads->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "messsage" =>"Thêm mới quảng cáo thành công"
        ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return [
                "success" => false,
                "status" => 400,
                "message" => 'message:'.$exception->getMessage().'Line'.$exception->getLine()
            ];
        }
    	
    }
    public function edit($id)
    {
        $ads = Config::find($id);
        return [
            "success" => true,
            "status" => 200,
            "ads" => $ads
        ];
    }
    public function update(UpdateAdsRequest $req,$id)
    {
        try{
            DB::beginTransaction();
            $ads = Config::find($id);
            $ads->name= $req->name;
            $ads->slug= $req->slug;
            $ads->value= $req->value;
            $ads->type= 2;
            $ads->status= $req->status;
            $ads->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "messsage" =>"Cập nhật quảng cáo thành công"
        ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return [
                "success" => false,
                "status" => 400,
                "message" => 'message:'.$exception->getMessage().'Line'.$exception->getLine()
            ];
        }
        
    }
    public function hidden($id)
    {
        $ads = Config::find($id);
        $ads->status=0;
        $ads->save();
        return [
            "success" => true,
            "status" => 200,
            "messsage" => "Ẩn quảng cáo thành công"
        ];
    }
}