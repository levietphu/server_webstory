<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truyen;
use App\Models\Chuongtruyen;
use DB;
use Log;
use App\Http\Requests\AddChuongtruyenRequest;
use App\Http\Requests\UpdateChuongtruyenRequest;

class ChuongtruyenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_truyen)
    {
        $chuongtruyen = Chuongtruyen::orderby('created_at','desc')->where('id_truyen',$id_truyen)->get();
        $name = Truyen::find($id_truyen)->name;
        return view('backend.chuongtruyen.index', compact('chuongtruyen','id_truyen','name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_truyen)
    {
        $truyen = Truyen::find($id_truyen);
        return view('backend.chuongtruyen.create',compact('id_truyen','truyen'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddChuongtruyenRequest $req,$id_truyen)
    {
        try{
            DB::beginTransaction();

            $chuongtruyen = new Chuongtruyen;
            $chuongtruyen->id_truyen=$id_truyen;
            $chuongtruyen->name_chapter= $req->name_chapter;
            $chuongtruyen->chapter_number= $req->chapter_number;
            $chuongtruyen->slug= $req->slug;
            $chuongtruyen->content= $req->content;
            $chuongtruyen->coin= $req->coin;
            $chuongtruyen->save();
            DB::commit();
            return redirect()->route('chuongtruyen.index',$id_truyen)->with('success','Thêm mới thành công');
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
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
    public function edit($id_truyen,$id)
    {
        $truyen = Truyen::find($id_truyen);
        $edit = Chuongtruyen::find($id);
        return view('backend.chuongtruyen.edit',compact('edit','id_truyen','truyen'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChuongtruyenRequest $req, $id_truyen,$id)
    {
        try{
            DB::beginTransaction();
            $chuongtruyen = Chuongtruyen::find($id);
            $chuongtruyen->id_truyen=$id_truyen;
            $chuongtruyen->name_chapter= $req->name_chapter;
            $chuongtruyen->chapter_number= $req->chapter_number;
            $chuongtruyen->slug= $req->slug;
            $chuongtruyen->content= $req->content;
            $chuongtruyen->coin= $req->coin;
            $chuongtruyen->save();
            DB::commit();
            return redirect()->route('chuongtruyen.index',$id_truyen)->with('success','Cập nhật thành công');
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
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
        return redirect()->back()->with('success','Xóa thành công');
    }
}
