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
        $check = Truyen::orderby('created_at','desc')->select('id','name','full','vip','status')->get();
        $story = json_decode(json_encode($check));
        foreach ($check as $key => $value) {
            $story[$key]->all_chapter = $value->chuong->count();
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
        $tacgia = Tacgia::all();
        $dichgia = Translator::all();
        $theloai = Theloai::orderby('created_at','desc')->get();
        return [
            "success"=>true,
            "status"=>200,
            'author'=>$tacgia,
            'translator'=>$dichgia,
            'cate'=>$theloai,
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddTruyenRequest $req)
    {
         $image = $req->file('image')->getClientOriginalName();  

        //upload ảnh lên thư mục      
        $req->file('image')->move('public/uploads/Truyện/', $image);
        try{
            DB::beginTransaction();
            $truyen = new Truyen;
            $truyen->id_tacgia = $req->id_author;
            $truyen->id_trans = $req->id_trans;
            $truyen->name= $req->name;
            $truyen->slug= $req->slug;
            $truyen->introduce= $req->introduce;
            $truyen->image= 'Truyện/'.$image;
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
            "messsage" =>"Thêm mới truyện thành công"
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
        $edit['author'] = $tacgia;
        $edit['trans'] = $dichgia;
        $edit['cate'] = $theloai;
        $edit['user']=User::find($edit->id_user);
        return [
            "success" => true,
            "status" => 200,
            "edit" =>"$edit"
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
        $image = $req->file('image')->getClientOriginalName();  

        //upload ảnh lên thư mục      
        $req->file('image')->move('public/uploads/Truyện/', $image);
        try{
            DB::beginTransaction();
            $truyen = Truyen::find($id);
            $truyen->id_tacgia = $req->id_author;
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
            "messsage" =>"Cập nhật truyện thành công"
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Truyen::find($id)->delete();
        return [
            "success" => true,
            "status" => 200,
            "messsage" =>"Xóa truyện thành công"
        ];
    }
}
