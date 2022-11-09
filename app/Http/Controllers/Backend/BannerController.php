<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Truyen;
use App\Http\Requests\AddBannerRequest;
use DB;
use Log;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banner = Banner::orderby('created_at','desc')->get();
        
        return view('backend.banner.index',compact('banner'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $truyen = Truyen::orderby('created_at','desc')->get();
        return view('backend.banner.create',compact('truyen'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddBannerRequest $req)
    {
        $image = str_replace(url('public/uploads'),'',$req->image) ;
        try{
            DB::beginTransaction();
            $banner = new Banner;
            $banner->name= $req->name;
            $banner->image= $image;
            $banner->status= $req->status;
            $banner->id_truyen= $req->id_truyen;
            $banner->save();

            DB::commit();
            return redirect()->route('banner.index')->with('success','Thêm mới thành công');
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
        $edit = Banner::find($id);
        $truyen = Truyen::orderby('created_at','desc')->get();
        return view('backend.banner.edit',compact('edit','truyen'));
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
        $image = str_replace(url('public/uploads'),'',$req->image) ;
        try{
            DB::beginTransaction();
            $banner =Banner::find($id);
            $banner->name= $req->name;
            $banner->image= $image;
            $banner->status= $req->status;
            $banner->id_truyen= $banner->id_truyen ?$banner->id_truyen: $req->id_truyen;
            $banner->save();

            DB::commit();
            return redirect()->route('banner.index')->with('success','Cập nhật thành công');
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
        Banner::find($id)->delete();
        return redirect()->back()->with('success','Xóa thành công');
    }
}
