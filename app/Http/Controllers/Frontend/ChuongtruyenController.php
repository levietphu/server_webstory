<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chuongtruyen;
use App\Models\Truyen;

class ChuongtruyenController extends Controller
{
    public function index($slug_truyen,$slug_chapter)
    {
        $truyen = Truyen::where('slug',$slug_truyen)->first();
        $chuongtruyen = Chuongtruyen::where('id_truyen',$truyen->id)->where('slug',$slug_chapter)->first();
        $all_chuongtruyen = Chuongtruyen::where('id_truyen',$truyen->id)->get();
        $count_chuong = Chuongtruyen::where('id_truyen',$truyen->id)->get()->count();
        $chapter_prev = Chuongtruyen::where('id_truyen',$truyen->id)->where('id','<',$chuongtruyen->id)->orderby('created_at','desc')->first();
        $chapter_next = Chuongtruyen::where('id_truyen',$truyen->id)->where('id','>',$chuongtruyen->id)->orderby('created_at','asc')->first();

        if ($chapter_prev==null) {
            $slug_prev='';
        }else{
            $slug_prev = $chapter_prev->slug;
        }

        if ($chapter_next==null) {
            $slug_next='';
        }else{
            $slug_next = $chapter_next->slug;
        }

        $id_min = Chuongtruyen::where('id_truyen',$truyen->id)->orderby('created_at','asc')->first()->id;
        $id_max= Chuongtruyen::where('id_truyen',$truyen->id)->orderby('created_at','desc')->first()->id;
        return view('frontend.pages.chapter', compact('chuongtruyen','truyen','count_chuong','all_chuongtruyen','slug_prev','slug_next','id_max','id_min'));
    }
}
