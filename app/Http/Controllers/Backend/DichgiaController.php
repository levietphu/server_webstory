<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Translator;
use DB;
use Log;

class DichgiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dichgia = Translator::orderby('created_at','desc')->get();
        return view('backend.dichgia.index', compact('dichgia'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.dichgia.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        try{
            DB::beginTransaction();
            $Translator = new Translator;
            $Translator->name= $req->name;
            $Translator->slug= $req->slug;
            $Translator->save();
            DB::commit();
            return redirect()->route('dichgia.index')->with('success','Thêm mới thành công');
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
        $edit = Translator::find($id);
        return view('backend.dichgia.edit',compact('edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        try{
            DB::beginTransaction();
            $Translator = Translator::find($id);
            $Translator->name= $req->name;
            $Translator->slug= $req->slug;
            $Translator->save();
            DB::commit();
            return redirect()->route('dichgia.index')->with('success','Cập nhật thành công');
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
        Translator::find($id)->delete();
        return redirect()->back()->with('success','Xóa thành công');
    }
}
