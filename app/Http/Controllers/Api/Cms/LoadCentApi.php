<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoadCent;
// use App\Http\Requests\AddLoadCentRequest;
// use App\Http\Requests\UpdateLoadCentRequest;
use DB;
use Log;

class LoadCentApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_bankinfo)
    {
        $load_cent = LoadCent::where("id_bankinfo",$id_bankinfo)->orderby("value","asc")->get();
        return [
        	"success" => true,
        	"status" => 200,
        	"load_cent" => $load_cent
        ];
    }
    public function create(Request $req,$id_bankinfo)
    {

        try{
            DB::beginTransaction();
            $load_cent = new LoadCent;
            $load_cent->id_bankinfo= $id_bankinfo;
            $load_cent->value= $req->value;
            $load_cent->coins= $req->coins;
            $load_cent->bonus= $req->bonus;
            $load_cent->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "message" =>"Thêm mới Nạp xu thành công"
        ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return abort(500,$exception->getMessage().'Line'.$exception->getLine());
        }
    	
    }

    public function update(Request $req,$id)
    {
        try{
            DB::beginTransaction();
            $load_cent = LoadCent::find($id);
            $load_cent->value= $req->value;
            $load_cent->coins= $req->coins;
            $load_cent->bonus= $req->bonus;
            $load_cent->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "message" =>"Cập nhật Nạp xu thành công"
        ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
           return abort(500,$exception->getMessage().'Line'.$exception->getLine());
        }
        
    }
    public function delete($id)
    {
        LoadCent::find($id)->delete();
        return [
            "success" => true,
            "status" => 200,
            "message" => "Xóa Nạp xu thành công"
        ];
    }
}