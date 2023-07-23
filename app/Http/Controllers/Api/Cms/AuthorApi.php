<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tacgia;
use App\Http\Requests\AddTacgiaRequest;
use App\Http\Requests\UpdateTacgiaRequest;
use DB;
use Log;

class AuthorApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $author = Tacgia::orderby("created_at","desc")->get();
        return [
        	"success" => true,
        	"status" => 200,
        	"author" => $author
        ];
    }
    public function create(AddTacgiaRequest $req)
    {
        try{
            DB::beginTransaction();
            $tacgia = new Tacgia;
            $tacgia->name= $req->name;
            $tacgia->slug= $req->slug;
            $tacgia->status= $req->status;
            $tacgia->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "messsage" =>"Thêm mới tác giả thành công"
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
        $author = Tacgia::find($id);
        return [
            "success" => true,
            "status" => 200,
            "author" => $author
        ];
    }
    public function update(UpdateTacgiaRequest $req,$id)
    {
        try{
            DB::beginTransaction();
            $tacgia = Tacgia::find($id);
            $tacgia->name= $req->name;
            $tacgia->slug= $req->slug;
            $tacgia->status= $req->status;
            $tacgia->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "messsage" =>"Cập nhật tác giả thành công"
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
    public function delete($id)
    {
        Tacgia::find($id)->delete();
        return [
            "success" => true,
            "status" => 200,
            "messsage" => "Xóa tác giả thành công"
        ];
    }
}