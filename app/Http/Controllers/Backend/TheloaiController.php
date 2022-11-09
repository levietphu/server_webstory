<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Theloai;
use DB;
use Log;
use App\Http\Requests\AddTheloaiRequest;
use App\Http\Requests\UpdateTheloaiRequest;

class TheloaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $theloai = Theloai::orderby('created_at','desc')->get();
        return view('backend.theloai.index', compact('theloai'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.theloai.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddTheloaiRequest $req)
    {
        try{
            DB::beginTransaction();
            $theloai = new Theloai;
            $theloai->name= $req->name;
            $theloai->slug= $req->slug;
            $theloai->status= $req->status;
            $theloai->save();
            DB::commit();
            return redirect()->route('theloai.index')->with('success','Thêm mới thành công');
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
        $edit = Theloai::find($id);
        return view('backend.theloai.edit',compact('edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTheloaiRequest $req, $id)
    {
        try{
            DB::beginTransaction();
            $theloai = Theloai::find($id);
            $theloai->name= $req->name;
            $theloai->slug= $req->slug;
            $theloai->status= $req->status;
            $theloai->save();
            DB::commit();
            return redirect()->route('theloai.index')->with('success','Cập nhật thành công');
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
        Theloai::find($id)->delete();
        return redirect()->back()->with('success','Xóa thành công');
    }
}
