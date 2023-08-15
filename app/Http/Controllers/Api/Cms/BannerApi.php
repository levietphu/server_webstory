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
        $banner = Banner::orderby("created_at","desc")->get();
        $story = Truyen::select("id",'name')->get();
        return [
            "success" => true,
            "status" => 200,
            "banner" => $banner,
            "story" => $story
        ];
    }


    public function uploadBanner(Request $req,$id)
    {
        if($id){
            $banner = Banner::find($id);
            unlink(public_path(
                "/uploads/".$banner->image));
        }
        $image = $req->file('image')->getClientOriginalName();  

        //upload ảnh lên thư mục      
        $req->file('image')->move('public/uploads/Banner/', $image);
    }

    public function create(AddBannerRequest $req)
    {
        try{
            DB::beginTransaction();
            $banner = new Banner;
            $banner->name= $req->name;
            $banner->image= "Banner/".$req->image['file']['name'];
            $banner->status= $req->status;
            $banner->id_truyen= $req->id_truyen;
            $banner->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "message" =>"Thêm mới banner thành công"
        ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return abort(500,$exception->getMessage().'Line'.$exception->getLine());
        }
        
    }

    public function update(AddBannerRequest $req,$id)
    {
        $banner = Banner::find($id);
        if(gettype($req->image)=="string"){
            $image=$req->image;
        }else{
            $image = "Banner/".$req->image['file']['name'];
        }
        try{
            DB::beginTransaction();
            
            $banner->name= $req->name;
            $banner->image=$image;
            $banner->status= $req->status;
            $banner->id_truyen= $req->id_truyen;
            $banner->save();
            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "message" =>"Cập nhật banner thành công"
        ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return abort(500,$exception->getMessage().'Line'.$exception->getLine());
        }
        
    }
    public function delete($id)
    {
        $banner = Banner::find($id);
        $banner->delete();
         unlink(public_path(
                "/uploads".$banner->image));
        return [
            "success" => true,
            "status" => 200,
            "message" => "Xóa banner thành công"
        ];
    }
}