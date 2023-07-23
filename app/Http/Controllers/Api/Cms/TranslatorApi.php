<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Translator;
use App\Http\Requests\AddTranslatorRequest;
use App\Http\Requests\UpdateTranslatorRequest;
use DB;
use Log;

class TranslatorApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trans = Translator::where('status',1)->orderby("created_at","desc")->get();
        return [
        	"success" => true,
        	"status" => 200,
        	"trans" => $trans
        ];
    }
    public function create(AddTranslatorRequest $req)
    {

        try{
            DB::beginTransaction();
            $trans = new Translator;
            $trans->name= $req->name;
            $trans->slug= $req->slug;
            $trans->id_user= $req->id_user;
            $trans->status= $req->status;
            $trans->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "messsage" =>"Thêm mới dịch giả thành công"
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
        $trans = Translator::find($id);
        return [
            "success" => true,
            "status" => 200,
            "trans" => $trans
        ];
    }
    public function update(UpdateTranslatorRequest $req,$id)
    {
        try{
            DB::beginTransaction();
            $trans = Translator::find($id);
            $trans->name= $req->name;
            $trans->slug= $req->slug;
            $trans->id_user= $req->id_user;
            $trans->status= $req->status;
            $trans->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "messsage" =>"Cập nhật dịch giả thành công"
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
        $trans = Translator::find($id);
        $trans->status=0;
        $trans->save();
        return [
            "success" => true,
            "status" => 200,
            "messsage" => "Ẩn dịch giả thành công"
        ];
    }
}