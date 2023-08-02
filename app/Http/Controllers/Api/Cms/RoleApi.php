<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use DB;
use Log;
use App\Http\Requests\AddRoleRequest;

class RoleApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $check = Role::all();
        $role = json_decode(json_encode($check));
        foreach ($check as $key => $value) {
            $role[$key]->role_per = $value->getPer()->select('permissions.id','permissions.name_per')->get();
        }
        $per = Permission::all();
        return [
        	"success" => true,
        	"status" => 200,
        	"role" => $role,
            "per" => $per,
        ];
    }


    public function create(AddRoleRequest $req)
    {
        try{
            DB::beginTransaction();
            $role = new Role;
            $role->name= $req->name;
            $role->status= $req->status;
            $role->save();

            $role->getPer()->attach($req->id_per);
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "message" =>"Thêm mới vai trò thành công"
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

    public function update(AddRoleRequest $req,$id)
    {
        try{
            DB::beginTransaction();
            $role = Role::find($id);
            $role->name= $req->name;
            $role->status= $req->status;
            $role->save();
            $role->getPer()->sync($req->id_per);
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "message" =>"Cập nhật vai trò thành công"
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
        DB::table("role_permission")->where("id_role",$id)->delete();
        Role::find($id)->delete();
        return [
            "success" => true,
            "status" => 200,
            "message" => "Xóa vai trò thành công"
        ];
    }
}