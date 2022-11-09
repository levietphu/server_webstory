<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truyen;
use App\Models\Chuongtruyen;
use App\Models\Theloai;
use App\Models\Tacgia;
use App\Models\Translator;
use DB;
use Log;
use App\Http\Requests\AddTruyenRequest;
use App\Http\Requests\UpdateTruyenRequest;

class TruyenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $truyen = Truyen::orderby('created_at','desc')->get();
        // $count_chapter = Chuongtruyen::join("truyens", 'truyens.id','=','chuongtruyens.id_truyen')->count();
        // dd($count_chapter);
        return view('backend.truyen.index', compact('truyen'));
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
        return view('backend.truyen.create', compact('theloai','tacgia','dichgia'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddTruyenRequest $req)
    {
        $image = str_replace(url('public/uploads'),'',$req->image) ;
        try{
            DB::beginTransaction();
            $truyen = new Truyen;
            $truyen->id_tacgia = $req->id_tacgia;
            $truyen->id_trans = $req->id_trans;
            $truyen->name= $req->name;
            $truyen->slug= $req->slug;
            $truyen->introduce= $req->introduce;
            $truyen->image= $image;
            $truyen->discount= $req->discount;
            $truyen->recommended= $req->recommended;
            $truyen->status= $req->status;
            $truyen->full= $req->full;
            $truyen->vip= $req->vip;
            $truyen->hot= $req->hot;
            $truyen->save();
            $truyen->truyen()->attach($req->id_theloai);

            DB::commit();
            return redirect()->route('truyen.index')->with('success','Thêm mới thành công');
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
    public function edit($id)
    {
        $tacgia = Tacgia::all();
        $dichgia = Translator::all();
        $theloai = Theloai::orderby('created_at','desc')->get();
        $edit = Truyen::find($id);
        return view('backend.truyen.edit',compact('edit','tacgia','theloai','dichgia'));
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
        $image = str_replace(url('public/uploads'),'',$req->image) ;
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
            $truyen->save();
            $truyen->truyen()->sync($req->id_theloai);

            DB::commit();
            return redirect()->route('truyen.index')->with('success','Cập nhật thành công');
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
        Truyen::find($id)->delete();
        return redirect()->back()->with('success','Xóa thành công');
    }
}
