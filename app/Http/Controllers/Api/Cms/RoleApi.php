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
        foreach ($check as $key => $value) {
            $role[$value->name] = $value->getPer()->get()->count();
        }
        return [
        	"success" => true,
        	"status" => 200,
        	"role" => $role
        ];
    }

    public function create()
    {
        $permission = Permission::get();
        return [
            "success" => true,
            "status"=>200,
            "all_per" => $permission
        ];
    }
    public function store(AddRoleRequest $req)
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
            "messsage" =>"Thêm mới vai trò thành công"
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
        $role = Role::find($id);
        $permission = Permission::get();
        $role->view_per =  $role->getPer()->select("slug")->get();
        $role->all_per = $permission;
        return [
            "success" => true,
            "status" => 200,
            "role" => $role,
        ];
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
            "messsage" =>"Cập nhật vai trò thành công"
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
        $role = Role::find($id)->delete();
        $role->status=0;
        $role->save();
        return [
            "success" => true,
            "status" => 200,
            "messsage" => "Ẩn vai trò thành công"
        ];
    }
}