<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use DB;
use Log;

class UserApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $check = User::all();
        foreach ($check as $value) {
            $user[$value->name] = $value->getRole()->get();
        }
        $user->role = Role::get();
        return [
        	"success" => true,
        	"status" => 200,
        	"user" => $user
        ];
    }

    public function add_role(Request $req)
    {
        try{
            DB::beginTransaction();
            $user = User::find($req->id);
            $user->getRole()->attach($req->id_role);
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "messsage" =>"Thêm vai trò cho user thành công"
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
    public function update(Request $req)
    {
        try{
            DB::beginTransaction();
            $user = User::find($req->id);
            $user->getRole()->sync($req->id_per);
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "messsage" =>"Cập nhật vai trò cho user thành công"
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
    public function hidden(Request $req)
    {
        $user = User::find($req->id);
        $user->status=0;
        $user->save();
        return [
            'success' => true,
            "status"=>200,
            "message"=>"User bị cấm hoạt động thành công"
        ];
    }
    
}