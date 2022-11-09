<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truyen;
use App\Models\Chuongtruyen;
use App\Models\Banner;
use DB;
use Session;

class HomeController extends Controller
{
    public function index()
    {
        $truyenmoi=Truyen::join('chuongtruyens','truyens.id','=','chuongtruyens.id_truyen')
        ->groupby('chuongtruyens.id_truyen')->orderby(DB::raw('max(chuongtruyens.created_at)'), 'desc')
        ->select('truyens.*')
        ->limit(10)
        ->get();
        $truyenhot = Truyen::orderby('view_count','desc')->limit(5)->get();
        $truyenfull = Truyen::where('status',0)->limit(8)->get();
        $banner = Banner::orderby('created_at','desc')->limit(3)->get();
        return view('frontend.pages.home', compact('truyenmoi','truyenhot','truyenfull','banner'));
    }
}
