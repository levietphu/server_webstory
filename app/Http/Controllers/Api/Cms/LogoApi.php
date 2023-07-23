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
        $logo = Config::where('type',1)->where('status',1)->orderby("created_at","desc")->get();
        return [
        	"success" => true,
        	"status" => 200,
        	"logo" => $logo
        ];
    }
    public function create(AddLogoRequest $req)
    {
         $value = $req->file('value')->getClientOriginalName();  

        //upload ảnh lên thư mục      
        $req->file('value')->move('public/uploads/Config/', $value);
        try{
            DB::beginTransaction();
            $logo = new Config;
            $logo->name= $req->name;
            $logo->slug= $req->slug;
            $logo->type= 1;
            $logo->value= "Config/".$value;
            $logo->status= $req->status;
            $logo->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "messsage" =>"Thêm mới Logo thành công"
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
        $logo = Config::find($id);
        return [
            "success" => true,
            "status" => 200,
            "logo" => $logo
        ];
    }
    public function update(UpdateLogoRequest $req,$id)
    {
        $value = $req->file('value')->getClientOriginalName();  

        //upload ảnh lên thư mục      
        $req->file('value')->move('public/uploads/Config/', $value);
        try{
            DB::beginTransaction();
            $logo = Config::find($id);
            $logo->name= $req->name;
            $logo->slug= $req->slug;
            $logo->value= "Config/".$value;
            $logo->type= 1;
            $logo->status= $req->status;
            $logo->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "messsage" =>"Cập nhật logo thành công"
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
            "messsage" => "Ẩn logo thành công"
        ];
    }
}