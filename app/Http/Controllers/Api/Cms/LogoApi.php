<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use App\Http\Requests\AddLogoRequest;
use App\Http\Requests\UpdateLogoRequest;
use DB;
use Log;

class LogoApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logo = Config::where('type',1)->orderby("created_at","desc")->where('status',1)->get();
        return [
        	"success" => true,
        	"status" => 200,
        	"logo" => $logo
        ];
    }
    public function uploadLogo(Request $req){
        $value = $req->file('value')->getClientOriginalName();  

        //upload ảnh lên thư mục      
        $req->file('value')->move('public/uploads/Config/', $value);

        
    }
    public function create(AddLogoRequest $req)
    {
        try{
            DB::beginTransaction();
            $logo = new Config;
            $logo->name= $req->name;
            $logo->slug= $req->slug;
            $logo->type= 1;
            $logo->value= $req->value['file']['name'];
            $logo->status= $req->status;
            $logo->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "message" =>"Thêm mới Logo thành công"
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

    public function update(UpdateLogoRequest $req,$id)
    {
        $logo = Config::find($id);
        if(gettype($req->value)=="string"){
            $value=$req->value;
        }else{
            unlink(public_path(
                "/uploads/Config/".$logo->value));
            $value = $req->value['file']['name'];
        }
        try{
            DB::beginTransaction();
            $logo->name= $req->name;
            $logo->slug= $req->slug;
            $logo->value= $value;
            $logo->type= 1;
            $logo->status= $req->status;
            $logo->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "message" =>"Cập nhật logo thành công"
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
        $logo = Config::find($id);
        $logo->status = 0;
        $logo->save();
        return [
            "success" => true,
            "status" => 200,
            "message" => "Ẩn logo thành công"
        ];
    }
}