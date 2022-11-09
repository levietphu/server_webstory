<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use App\Http\Requests\AddAdsRequest;
use App\Http\Requests\UpdateAdsRequest;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = Config::where('type', 2)->orderby('created_at', 'desc')->get();
        return view('backend.config.ads.index', compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ads = Config::where('type', 2)->get();
        return view('backend.config.ads.create', compact('ads'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $ads = new Config;
        $ads ->name = $req->name;
        $ads ->slug = $req->slug;
        $ads ->value = $req->value;
        $ads ->type = 2;
        $ads ->status = $req->status;
        $ads->save();
        return redirect()->route('ads.index')->with('success', 'Thêm quảng cáo thành công');
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
        $ads = Config::find($id);
        return view('backend.config.ads.edit', compact('ads'));
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
        $ads = Config::find($id);
        $ads ->name = $req->name;
        $ads ->slug = $req->slug;
        $ads ->value = $req->value;
        $ads ->type = 2;
        $ads ->status = $req->status;
        $ads -> save();
        return redirect()->route('ads.index')->with('success', 'Cập nhật quảng cáo thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function hidden($id)
    {
        $ads = Config::find($id);
        if ($ads->status == 1) {
            $ads->status=0;
        }else{
            $ads->status =1;
        }
        $ads->save();
        return redirect()->back()->with('success','Ẩn/Hiện quảng cáo thành công');
    }
    
}
