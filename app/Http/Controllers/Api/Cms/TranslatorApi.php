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
        $check = Translator::orderby("created_at","desc")->get();
        $trans= json_decode(json_encode($check));
        foreach ($check as $key => $value) {
            // $user_name = $trans->getUserAdd->name;
            $trans[$key]->name_user_add = $value->getUserAdd->name;
        }
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
            "message" =>"Thêm mới dịch giả thành công"
        ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return abort(500,$exception->getMessage().'Line'.$exception->getLine());
        }
    	
    }

    public function update(UpdateTranslatorRequest $req,$id)
    {
        try{
            DB::beginTransaction();
            $trans = Translator::find($id);
            $trans->name= $req->name;
            $trans->slug= $req->slug;
            $trans->status= $req->status;
            $trans->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "message" =>"Cập nhật dịch giả thành công"
        ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return abort(500,$exception->getMessage().'Line'.$exception->getLine());
        }
        
    }
    public function delete($id)
    {
        $trans = Translator::find($id)->delete();
        return [
            "success" => true,
            "status" => 200,
            "message" => "Xóa dịch giả thành công"
        ];
    }
}