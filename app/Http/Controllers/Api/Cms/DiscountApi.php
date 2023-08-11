<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount;
use App\Models\Truyen;
use App\Http\Requests\AddDiscountRequest;
use DB;
use Log;

class DiscountApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_truyen)
    {
        $discount = Discount::where("id_truyen",$id_truyen)->get();
        $name_story = Truyen::find($id_truyen)->name;
        return [
        	"success" => true,
        	"status" => 200,
        	"discount" => $discount,
            "name_story"=>$name_story
        ];
    }
    public function create(AddDiscountRequest $req,$id_truyen)
    {
        try{
            DB::beginTransaction();
            $discount = new Discount;
            $discount->number_chapter= $req->number_chapter;
            $discount->value= $req->value;
            $discount->id_truyen= $id_truyen;
            $discount->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "message" =>"Thêm mới giảm giá thành công"
        ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return [
                "success" => false,
                "status" => 500,
                "message" => 'message:'.$exception->getMessage().'Line'.$exception->getLine()
            ];
        }
    	
    }

    public function update(AddDiscountRequest $req,$id)
    {
        try{
            DB::beginTransaction();
            $discount = Discount::find($id);
            $discount->number_chapter= $req->number_chapter;
            $discount->value= $req->value;
            $discount->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "message" =>"Cập nhật giảm giá thành công"
        ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return [
                "success" => false,
                "status" => 500,
                "message" => 'message:'.$exception->getMessage().'Line'.$exception->getLine()
            ];
        }
        
    }
    public function delete($id)
    {
        Discount::find($id)->delete();

        return [
            "success" => true,
            "status" => 200,
            "message" => "Xóa giảm giá thành công"
        ];
    }
}