<?php

namespace App\Http\Controllers\Api\cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truyen;
use App\Models\Chuongtruyen;
use App\Models\Theloai;
use App\Models\Tacgia;
use App\Models\Translator;
use App\Models\User;
use DB;
use Log;
use App\Http\Requests\AddTruyenRequest;
use App\Http\Requests\UpdateTruyenRequest;

class StoryApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $check = Truyen::orderby('created_at','desc')->get();
        $story = json_decode(json_encode($check));
        
        foreach ($check as $key => $value) {
            $story[$key]->all_chapter = $value->chuong->count();
            $story[$key]->name_user = $value->getUserStory->name;
        }
        return [
            "success"=>true,
            "status"=>200,
            'story'=>$story
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $author = Tacgia::all();
        $trans = Translator::all();
        $cate = Theloai::all();
        return [
            "success"=>true,
            "status"=>200,
            'author'=>$author,
            'trans'=>$trans,
            'cate'=>$cate,
        ];
    }

    public function upload(Request $req,$id)
    {
        if($id){
            $story = Truyen::find($id);
            unlink(public_path(
                "/uploads/".$story->image));
        }
        $image = $req->file('image')->getClientOriginalName();  

        //upload ảnh lên thư mục      
        $req->file('image')->move('public/uploads/Truyện/', $image);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddTruyenRequest $req)
    {
         
        try{
            DB::beginTransaction();
            $truyen = new Truyen;
            $truyen->id_tacgia = $req->id_tacgia;
            $truyen->id_trans = $req->id_trans;
            $truyen->name= $req->name;
            $truyen->slug= $req->slug;
            $truyen->introduce= $req->introduce;
            $truyen->image= 'Truyện/'.$req->image['file']['name'];
            $truyen->discount= $req->discount;
            $truyen->recommended= $req->recommended;
            $truyen->status= $req->status;
            $truyen->full= $req->full;
            $truyen->vip= $req->vip;
            $truyen->hot= $req->hot;
            $truyen->id_user = $req->id_user;
            $truyen->save();
            $truyen->truyen()->attach($req->id_cate);

            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "message" =>"Thêm mới truyện thành công"
        ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
           return abort(500,$exception->getMessage().'Line'.$exception->getLine());
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tacgia = Tacgia::all();
        $dichgia = Translator::all();
        $theloai = Theloai::orderby('created_at','desc')->get();
        $edit = Truyen::find($id);
        $check = $edit->truyen()->select("theloais.id")->get();
        $id_cate =[];
        foreach ($check as $key => $value) {
            $id_cate[$key] = $value->id;
        }
        return [
            "success" => true,
            "status" => 200,
            "edit" =>$edit,
            "authors" =>$tacgia,
            "trans" =>$dichgia,
            "cates" =>$theloai,
            "id_cate" =>$id_cate,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTruyenRequest $req, $id)
    {
        if(gettype($req->image )== "string"){
            $image= $req->image;
        }else{
            $image = 'Truyện/'.$req->image['file']['name'];
        }

        try{
            DB::beginTransaction();
            $truyen = Truyen::find($id);
            $truyen->id_tacgia = $req->id_tacgia;
            $truyen->id_trans = $req->id_trans;
            $truyen->name= $req->name;
            $truyen->slug= $req->slug;
            $truyen->introduce= $req->introduce;
            $truyen->image= $image;
            $truyen->recommended= $req->recommended;
            $truyen->full= $req->full;
            $truyen->vip= $req->vip;
            $truyen->discount= $req->discount;
            $truyen->hot= $req->hot;
            $truyen->status= $req->status;
            $truyen->id_user = $req->id_user;
            $truyen->save();
            $truyen->truyen()->sync($req->id_cate);

            DB::commit();
            return [
            "success" => true,
            "status" => 200,
            "message" =>"Cập nhật truyện thành công"
        ];
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return abort(500,$exception->getMessage().'Line'.$exception->getLine());
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
        $story = Truyen::find($id);
        $story->delete();
        unlink(public_path(
                "/uploads".$story->image));
        return [
            "success" => true,
            "status" => 200,
            "message" =>"Xóa truyện thành công"
        ];
    }
}
