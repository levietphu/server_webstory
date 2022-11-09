<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Theloai;
use App\Models\Truyen;
use App\Models\Chuongtruyen;
use Carbon\Carbon;
use App\Models\View;
use DB;

class DanhmucController extends Controller
{
    public function theloai($slug)
    {
        $theloai = Theloai::where('slug',$slug)->first();
        $name_theloai = $theloai->name;
        $truyen = $theloai->truyenss()->paginate(10);

        // Sắp xếp truyện hot theo Hôm nay
        $start_today=Carbon::now()->startOfDay();
        $end_today=Carbon::now()->endOfDay();
        $truyenhot_sort_today=$theloai->truyenss()->join('views','views.id_truyen','=','truyens.id')->wherebetween('views.created_at',[$start_today,$end_today])->groupBy('views.id_truyen')->orderBy(DB::raw('COUNT(views.id_truyen)'),'desc')->limit(10)->get(array(DB::raw('COUNT(views.id_truyen) as total_view'), 'truyens.*'));

        // Sắp xếp truyện hot theo Tháng Này
        $start_this_month = Carbon::now()->startOfMonth();
        $end_this_month= Carbon::now()->endOfMonth();
        $truyenhot_sort_thisMonth=$theloai->truyenss()->join('views','views.id_truyen','=','truyens.id')->wherebetween('views.created_at',[$start_this_month,$end_this_month])->groupBy('views.id_truyen')->orderBy(DB::raw('COUNT(views.id_truyen)'),'desc')->limit(10)->get(array(DB::raw('COUNT(views.id_truyen) as total_view'), 'truyens.*'));

        // Sắp xếp truyện hot theo Tất cả
        $truyenhot_sort_all = $theloai->truyenss()->orderby('view_count','desc')->limit(10)->get();

        //Phân trang
        if(isset($_GET['page'])&&$_GET['page']>$truyen->lastPage()){
            return abort(404);
        }
        if (isset($_GET['page'])&&$_GET['page']<0) {
            return abort(404);
        }
        $page_limit = 4;
        $half_total_links = floor($page_limit / 2);
            $from = $truyen->currentPage() - $half_total_links;
            $to = $truyen->currentPage() + $half_total_links;
            if ($truyen->currentPage() < $half_total_links) {
               $to += $half_total_links - $truyen->currentPage();
            }
            if ($truyen->lastPage() - $truyen->currentPage() < $half_total_links) {
                $from -= $half_total_links - ($truyen->lastPage()- $truyen->currentPage());
            }
        return view('frontend.pages.theloai',compact('truyen','from','to','name_theloai','slug','truyenhot_sort_today','truyenhot_sort_thisMonth','truyenhot_sort_all'));
    }
    public function danhsach($slug)
    {
        // Sắp xếp truyện hot theo Hôm nay
        $start_today=Carbon::now()->startOfDay();
        $end_today=Carbon::now()->endOfDay();
        $truyenhot_sort_today=Truyen::join('views','views.id_truyen','=','truyens.id')->wherebetween('views.created_at',[$start_today,$end_today])->groupBy('views.id_truyen')->orderBy(DB::raw('COUNT(views.id_truyen)'),'desc')->limit(10)->get(array(DB::raw('COUNT(views.id_truyen) as total_view'), 'truyens.*'));
        // Sắp xếp truyện hot theo Tháng Này
        $start_this_month = Carbon::now()->startOfMonth();
        $end_this_month= Carbon::now()->endOfMonth();
        $truyenhot_sort_thisMonth=Truyen::join('views','views.id_truyen','=','truyens.id')->wherebetween('views.created_at',[$start_this_month,$end_this_month])->groupBy('views.id_truyen')->orderBy(DB::raw('COUNT(views.id_truyen)'),'desc')->limit(10)->get(array(DB::raw('COUNT(views.id_truyen) as total_view'), 'truyens.*'));
        // Sắp xếp truyện hot theo Tất cả
        $truyenhot_sort_all = Truyen::orderby('view_count','desc')->limit(10)->get();
        
        if ($slug=='truyen-full') {
            $truyen = Truyen::where('status',0)->paginate(10);
            if(isset($_GET['page'])&&$_GET['page']>$truyen->lastPage()){
            return abort(404);
            }
            if (isset($_GET['page'])&&$_GET['page']<0) {
                return abort(404);
            }
            $page_limit = 4;
            $half_total_links = floor($page_limit / 2);
                $from = $truyen->currentPage() - $half_total_links;
                $to = $truyen->currentPage() + $half_total_links;
                if ($truyen->currentPage() < $half_total_links) {
                   $to += $half_total_links - $truyen->currentPage();
                }
                if ($truyen->lastPage() - $truyen->currentPage() < $half_total_links) {
                    $from -= $half_total_links - ($truyen->lastPage()- $truyen->currentPage());
                }
            return view('frontend.pages.truyenfull', compact('truyen','truyenhot_sort_all','truyenhot_sort_today','from','to','truyenhot_sort_thisMonth'));
        }
        if ($slug=='truyen-moi') {
            $truyenmoi=Truyen::join('chuongtruyens','truyens.id','=','chuongtruyens.id_truyen')
        ->groupby('chuongtruyens.id_truyen')->orderby(DB::raw('max(chuongtruyens.created_at)'), 'desc')
        ->select('truyens.*')
        ->paginate(10);
            // dd($truyenmoi);
            if(isset($_GET['page'])&&$_GET['page']>$truyenmoi->lastPage()){
            return abort(404);
            }
            if (isset($_GET['page'])&&$_GET['page']<0) {
                return abort(404);
            }
            $page_limit = 4;
            $half_total_links = floor($page_limit / 2);
                $from = $truyenmoi->currentPage() - $half_total_links;
                $to = $truyenmoi->currentPage() + $half_total_links;
                if ($truyenmoi->currentPage() < $half_total_links) {
                   $to += $half_total_links - $truyenmoi->currentPage();
                }
                if ($truyenmoi->lastPage() - $truyenmoi->currentPage() < $half_total_links) {
                    $from -= $half_total_links - ($truyenmoi->lastPage()- $truyenmoi->currentPage());
                }
            return view('frontend.pages.truyenmoi', compact('truyenmoi','truyenhot_sort_thisMonth','from','to','truyenhot_sort_today','truyenhot_sort_all'));
        }
    }
}
