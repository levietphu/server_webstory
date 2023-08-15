<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankInfo;
use App\Http\Requests\AddBankInfoRequest;
use App\Http\Requests\UpdateBankInfoRequest;
use DB;
use Log;

class BankInfoApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bank_info = BankInfo::orderby("created_at","desc")->get();
        return [
        	"success" => true,
        	"status" => 200,
        	"bank_info" => $bank_info
        ];
    }

    public function create(AddBankInfoRequest $req)
    {
        
        $image = $req->file('image')->getClientOriginalName();
        $qrcode = $req->file("qr_code")->getClientOriginalName();

        //upload ảnh lên thư mục      
        $req->file('image')->move('public/uploads/BankInfo/', $image);
        $req->file('qr_code')->move('public/uploads/BankInfo/', $qrcode);
         try{
            DB::beginTransaction();
            $bank_info = new BankInfo;
            $bank_info->name_bank= $req->name_bank;
            $bank_info->owner= $req->owner;
            $bank_info->slug= $req->slug;
            $bank_info->qr_code= $qrcode;
            $bank_info->image= $image;
            $bank_info->type= $req->type;
            $bank_info->stk= $req->stk;
            $bank_info->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "message" =>"Thêm mới thông tin bank thành công"
        ];
        }catch(\Exception $exception){
            DB::rollback();

             unlink(public_path(
                "/uploads/BankInfo/".$image));
              unlink(public_path(
                "/uploads/BankInfo/".$qrcode));

            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return abort(500,$exception->getMessage().'Line'.$exception->getLine());
        }
    	
    }

    public function update(UpdateBankInfoRequest $req,$id)
    {
        $bank_info = BankInfo::find($id);

        if(gettype($req->image)=="string"){
            $image=$req->image;
        }else{
            $image = $req->file('image')->getClientOriginalName();  

            //upload ảnh lên thư mục      
            $req->file('image')->move('public/uploads/BankInfo/', $image);

            // Xóa ảnh cũ
            unlink(public_path(
            "/uploads/BankInfo/".$bank_info->image));
        }

        if(gettype($req->qr_code)=="string"){
            $qrcode=$req->qr_code;
        }else{
            $image = $req->file('qr_code')->getClientOriginalName();  

            //upload ảnh lên thư mục      
            $req->file('qr_code')->move('public/uploads/BankInfo/', $qrcode);

            // Xóa ảnh cũ
            unlink(public_path(
            "/uploads/BankInfo/".$bank_info->qrcode));
        }
        try{
            DB::beginTransaction();
            
            $bank_info->name_bank= $req->name_bank;
            $bank_info->owner= $req->owner;
            $bank_info->slug= $req->slug;
            $bank_info->qr_code= $qrcode;
            $bank_info->image= $image;
            $bank_info->type= $req->type;
            $bank_info->stk= $req->stk;
            $bank_info->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "message" =>"Cập nhật thông tin bank thành công"
        ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            if(gettype($req->image)!="string" || gettype($req->qr_code)!="string"){
                unlink(public_path(
                "/uploads/BankInfo/".$image));
                unlink(public_path(
                "/uploads/BankInfo/".$qr_code));
            }
        
            return abort(500,$exception->getMessage().'Line'.$exception->getLine());
        }
        
    }
    public function delete($id)
    {
        $bank_info=BankInfo::find($id);
         unlink(public_path(
        "/uploads/BankInfo/".$bank_info->image));
        unlink(public_path(
        "/uploads/BankInfo/".$bank_info->qr_code));
        $bank_info->delete();
        return [
            "success" => true,
            "status" => 200,
            "message" => "Xóa thông tin bank thành công"
        ];
    }
}