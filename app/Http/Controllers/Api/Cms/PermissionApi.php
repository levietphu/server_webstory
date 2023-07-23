<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use DB;
use Log;
use App\Http\Requests\AddPermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;

class PermissionApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $per = Permission::orderby("created_at","desc")->get();
        return [
        	"success" => true,
        	"status" => 200,
        	"per" => $per
        ];
    }
    public function create(AddPermissionRequest $req)
    {
        try{
            DB::beginTransaction();
            $per = new Permission;
            $per->name_per= $req->name_per;
            $per->slug= $req->slug;
            $per->status= $req->status;
            $per->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "messsage" =>"Thêm mới quyền thành công"
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
        $per = Permission::find($id);
        return [
            "success" => true,
            "status" => 200,
            "per" => $per
        ];
    }
    public function update(UpdatePermissionRequest $req,$id)
    {
        try{
            DB::beginTransaction();
            $per = Permission::find($id);
            $per->name_per= $req->name_per;
            $per->slug= $req->slug;
            $per->status= $req->status;
            $per->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "messsage" =>"Cập nhật quyền thành công"
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
        Permission::find($id)->delete();
        return [
            "success" => true,
            "status" => 200,
            "messsage" => "Xóa quyền thành công"
        ];
    }
}