<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tacgia;
use DB;
use Log;
use App\Http\Requests\AddTacgiaRequest;
use App\Http\Requests\UpdateTacgiaRequest;

class TacgiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tacgia = Tacgia::orderby('created_at','desc')->get();
        return view('backend.tacgia.index', compact('tacgia'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.tacgia.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddTacgiaRequest $req)
    {
        try{
            DB::beginTransaction();
            $tacgia = new Tacgia;
            $tacgia->name= $req->name;
            $tacgia->slug= $req->slug;
            $tacgia->status= $req->status;
            $tacgia->save();
            DB::commit();
            return redirect()->route('tacgia.index')->with('success','Thêm mới thành công');
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
        $edit = Tacgia::find($id);
        return view('backend.tacgia.edit',compact('edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTacgiaRequest $req, $id)
    {
        try{
            DB::beginTransaction();
            $tacgia = Tacgia::find($id);
            $tacgia->name= $req->name;
            $tacgia->slug= $req->slug;
            $tacgia->status= $req->status;
            $tacgia->save();
            DB::commit();
            return redirect()->route('tacgia.index')->with('success','Cập nhật thành công');
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
        Tacgia::find($id)->delete();
        return redirect()->back()->with('success','Xóa thành công');
    }
}
