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
        $user = json_decode(json_encode($check));
        foreach ($check as $key => $value) {
            $user[$key]->role = $value->getRole()->select('roles.id','roles.name','roles.status')->get();
        }
        $role = Role::all();
        return [
        	"success" => true,
        	"status" => 200,
        	"user" => $user,
            "role" => $role,
        ];
    }

  
    public function update_role(Request $req,$id)
    {
        try{
            DB::beginTransaction();
            $user = User::find($id);
            $user->getRole()->sync($req->id_role);
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "message" =>"Cập nhật vai trò cho user thành công"
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

public function add_coin(Request $req,$id)
    {
        try{
            DB::beginTransaction();
            $user = User::find($id);
            $user->coin = $user->coin + $req->coin;
            $user->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "message" =>"Thêm xu thành công"
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

    public function block($id)
    {
        $user = User::find($id);
        if ($user->status ==1) {
            $user->status=0;
            $user->save();
            return [
                'success' => true,
                "status"=>200,
                "message"=>"User bị cấm hoạt động thành công"
            ];
        }else{
            $user->status=1;
            $user->save();
            return [
                'success' => true,
                "status"=>200,
                "message"=>"User hoạt động trở lại"
            ];
        }
        
        
    }
    
}