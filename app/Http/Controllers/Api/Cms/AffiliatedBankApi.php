<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AffiliatedBank;
use App\Models\User;
use App\Http\Requests\AffiliatedBankRequest;
use DB;
use Log;

class AffiliatedBankApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {

       $affiliated_banks = AffiliatedBank::where("id_user",$req->id_user)->get();

        return [
        	"success" => true,
        	"status" => 200,
        	"affiliated_banks" => $affiliated_banks
        ];
    }

   public function create(AffiliatedBankRequest $req)
   {
        
         try{
            DB::beginTransaction();
            $image = $req->file('image')->getClientOriginalName();

            //upload ảnh lên thư mục      
            $req->file('image')->move('public/uploads/AffiliatedBank/', $image);

            $affiliated_banks = new AffiliatedBank;
            $affiliated_banks->id_user=$req->id_user;
            $affiliated_banks->owner_account=$req->owner_account;
            $affiliated_banks->name_bank=$req->name_bank;
            $affiliated_banks->slug=$req->slug;
            $affiliated_banks->stk=$req->stk;
            $affiliated_banks->image=$image;
            $affiliated_banks->save();

            DB::commit();
            return [
                "success" => true,
                "status" => 200,
                "message" =>"liên kết tài khoản thành công"
            ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return abort(500,$exception->getMessage().'Line'.$exception->getLine());
        }
   }
}