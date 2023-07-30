<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truyen;
use App\Models\Chuongtruyen;
use DB;
use Log;
use App\Http\Requests\AddChuongtruyenRequest;
use App\Http\Requests\UpdateChuongtruyenRequest;

class ChapterApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_story)
    {
        $chapter = Chuongtruyen::orderby('created_at','desc')->where('id_truyen',$id_story)->get();
        $name_story = Truyen::find($id_story)->name;
        return [
            "success"=>true,
            "status"=>200,
            'chapter'=>$chapter,
            "name_story"=>$name_story
        ];
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(AddChuongtruyenRequest $req,$id_story)
    {
        try{
            DB::beginTransaction();
            $chapter = new Chuongtruyen;
            $chapter->id_truyen=$id_story;
            $chapter->name_chapter= $req->name_chapter;
            $chapter->chapter_number= $req->chapter_number;
            $chapter->slug= $req->slug;
            $chapter->content= $req->content;
            $chapter->coin= $req->coin ? $req->coin:0;
            $chapter->save();
            DB::commit();
            return [
            "success"=>true,
            "status"=>200,
            'message'=>"Thêm chuong mới thành công"
        ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return [
            "success"=>false,
            "status"=>400,
            'message'=>'message:'.$exception->getMessage().'Line'.$exception->getLine()
        ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddChuongtruyenRequest $req, $id_story,$id_chapter)
    {
        try{
            DB::beginTransaction();
            $chapter = Chuongtruyen::find($id_chapter);
            $chapter->id_truyen=$id_story;
            $chapter->name_chapter= $req->name_chapter;
            $chapter->chapter_number= $req->chapter_number;
            $chapter->slug= $req->slug;
            $chapter->content= $req->content;
            $chapter->coin= $req->coin ? $req->coin:0;
            $chapter->save();
            DB::commit();
            return [
            "success"=>true,
            "status"=>200,
            'message'=>"Cập nhật chương thành công"
        ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return [
            "success"=>false,
            "status"=>400,
            'message'=>'message:'.$exception->getMessage().'Line'.$exception->getLine()
        ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Chuongtruyen::find($id)->delete();
        return [
            "success"=>false,
            "status"=>200,
            'message'=>'Xóa chương thành công'
        ];
    }
}
