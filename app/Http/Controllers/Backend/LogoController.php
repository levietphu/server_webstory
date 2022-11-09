<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
// use App\Http\Requests\AddLogoRequest;
// use App\Http\Requests\UpdateLogoRequest;

class LogoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logo = Config::where('type', 1)->where('status', 1)->orderby('created_at', 'desc')->get();
        return view('backend.config.logo.index', compact('logo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $logo = Config::where('type', 1)->get();
        return view('backend.config.logo.create', compact('logo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $value = str_replace(url('public/uploads/Config'), '', $req->value);
        $logo = new Config;
        $logo -> name = $req->name;
        $logo -> slug = $req->slug;
        $logo -> value = $value;
        $logo -> type = 1;
        $logo -> status = $req->status;
        $logo->save();
        return redirect()->route('logo.index')->with('success', 'Thêm logo thành công');
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
        $logo = Config::find($id);
        return view('backend.config.logo.edit', compact('logo'));
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
        $value = str_replace(url('public/uploads/Config'), '', $req->value);
        $logo = Config::find($id);
        $logo -> name = $req->name;
        $logo -> slug = $req->slug;
        $logo -> value = $value;
        $logo -> status = $req->status;
        $logo -> save();
        return redirect()->route('logo.index')->with('success', 'Cập nhật thành công');
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
 
}
