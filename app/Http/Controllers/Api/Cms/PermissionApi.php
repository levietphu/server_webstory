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
            "message" =>"Thêm mới quyền thành công"
        ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return abort(500);
        }
    	
    }

}