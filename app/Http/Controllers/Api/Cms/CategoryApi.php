<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Theloai;
use App\Http\Requests\AddTheloaiRequest;
use App\Http\Requests\UpdateTheloaiRequest;
use DB;
use Log;

class CategoryApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cate = Theloai::orderby('created_at','desc')->get();
        return [
            "success" => true,
            "status" => 200,
            "cate" => $cate
        ];
    }
    public function create(AddTheloaiRequest $req)
    {
        try{
            DB::beginTransaction();
            $cate = new Theloai;
            $cate->name= $req->name;
            $cate->slug= $req->slug;
            $cate->status= $req->status;
            $cate->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "message" =>"Thêm mới thể loại thành công"
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
        $cate = Theloai::find($id);
        return [
            "success" => true,
            "status" => 200,
            "cate" => $cate
        ];
    }
    public function update(UpdateTheloaiRequest $req,$id)
    {
        try{
            DB::beginTransaction();
            $cate = Theloai::find($id);
            $cate->name= $req->name;
            $cate->slug= $req->slug;
            $cate->status= $req->status;
            $cate->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "message" =>"Cập nhật thể loại thành công"
        ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return [
                "success" => false,
                "status" => 400,
                "message" => ':'.$exception->getMessage().'Line'.$exception->getLine()
            ];
        }
        
    }
    public function delete($id)
    {
        Theloai::find($id)->delete();
        return [
            "success" => true,
            "status" => 200,
            "message" => "Xóa thể loại thành công"
        ];
    }
}