<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Truyen;
use App\Http\Requests\AddBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use DB;
use Log;


class BannerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banner = Banner::orderby("created_at","desc")->where('status',1)->get();
        return [
            "success" => true,
            "status" => 200,
            "banner" => $banner
        ];
    }

    public function create()
    {
        $story = Truyen::select("id",'name')->get();
        return [
            "success" => true,
            "status" => 200,
            "story" => $story
        ];
    }

    public function store(AddBannerRequest $req)
    {
        $image = $req->file('image')->getClientOriginalName();  

        //upload ảnh lên thư mục      
        $req->file('image')->move('public/uploads/Banner/', $image);

        try{
            DB::beginTransaction();
            $banner = new Banner;
            $banner->name= $req->name;
            $banner->image= "Banner/".$image;
            $banner->status= $req->status;
            $banner->id_truyen= $req->id_truyen;
            $banner->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "messsage" =>"Thêm mới banner thành công"
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
        $banner = Banner::find($id);
        $story = Truyen::select("id",'name')->get();
        return [
            "success" => true,
            "status" => 200,
            "banner" => $banner,
            "story" =>$story
        ];
    }
    public function update(AddBannerRequest $req,$id)
    {
        $banner = Banner::find($id);
        $image = $req->file('image')->getClientOriginalName();  

        //upload ảnh lên thư mục      
        $req->file('image')->move('public/uploads/Banner/', $image);
        try{
            DB::beginTransaction();
            $banner->name= $req->name;
            $banner->image= "Banner/".$image;
            $banner->status= $req->status;
            $banner->id_truyen= $req->id_truyen;
            $banner->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "messsage" =>"Cập nhật banner thành công"
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
        Banner::find($id)->delete();
        return [
            "success" => true,
            "status" => 200,
            "messsage" => "Xóa banner thành công"
        ];
    }
}