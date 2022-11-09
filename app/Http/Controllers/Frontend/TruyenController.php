<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truyen;
use App\Models\Chuongtruyen;
use Carbon\Carbon;
use App\Events\ViewCount;
use DB;
use App\Models\View;
use App\Models\Tacgia;
use App\Models\Comment;
use App\Models\Review;
use Auth;
class TruyenController extends Controller
{
    public function view(Request $req, $slug_truyen)
    {
        $truyen=Truyen::where('slug',$slug_truyen)->first();
        // $comment = Comment::where('id_truyen',$truyen->id)->where('id_parent',0)->orderby('created_at','desc')->get();
        // đánh giá
        // $review = Review::where('id_truyen',$truyen->id)->get();
        // $count_review = count($review);
        // $check_score=0;
        // if ($count_review!=0) {
        //     foreach ($review as $value) {
        //     $check_score += $value->score;
        //     }
        //     $score=round($check_score/$count_review);
        // }else{
        //     $score=0;
        // };
        // $review_user = Review::where('id_truyen',$truyen->id)->where('id_user',Auth::id())->get();
        $chuong = Chuongtruyen::where('id_truyen',$truyen->id)->paginate(10);
        $tacgia = Tacgia::find($truyen->id_tacgia);
        $tacgia_truyen = $tacgia->tacgia_truyen()->where('slug','!=',$slug_truyen)->get();
        // Sắp xếp truyện hot theo Hôm nay
        $start_today=Carbon::now()->startOfDay();
        $end_today=Carbon::now()->endOfDay();
        $truyenhot_sort_today=Truyen::join('views','views.id_truyen','=','truyens.id')->wherebetween('views.created_at',[$start_today,$end_today])->groupBy('views.id_truyen')->orderBy(DB::raw('COUNT(views.id_truyen)'),'desc')->limit(4)->get(array(DB::raw('COUNT(views.id_truyen) as total_view'), 'truyens.*'));

        // Sắp xếp truyện hot theo Tháng Này
        $start_this_month = Carbon::now()->startOfMonth();
        $end_this_month= Carbon::now()->endOfMonth();
        $truyenhot_sort_thisMonth=Truyen::join('views','views.id_truyen','=','truyens.id')->wherebetween('views.created_at',[$start_this_month,$end_this_month])->groupBy('views.id_truyen')->orderBy(DB::raw('COUNT(views.id_truyen)'),'desc')->limit(4)->get(array(DB::raw('COUNT(views.id_truyen) as total_view'), 'truyens.*'));

        // Sắp xếp truyện hot theo Tất cả
        $truyenhot_sort_all = Truyen::orderby('view_count','desc')->limit(4)->get();

        if(isset($_GET['page'])&&$_GET['page']>$chuong->lastPage()){
            return abort(404);
        }
        if (isset($_GET['page'])&&$_GET['page']<0) {
            return abort(404);
        }
        $page_limit = 4;
        $half_total_links = floor($page_limit / 2);
            $from = $chuong->currentPage() - $half_total_links;
            $to = $chuong->currentPage() + $half_total_links;
            if ($chuong->currentPage() < $half_total_links) {
               $to += $half_total_links - $chuong->currentPage();
            }
            if ($chuong->lastPage() - $chuong->currentPage() < $half_total_links) {
                $from -= $half_total_links - ($chuong->lastPage()- $chuong->currentPage());
            }
            // search, pagination ajax
            if($req->ajax()){
                $truyen=Truyen::where('slug',$slug_truyen)->first();
                $search_chapter = $req->get('search_chapter');
                $chuong = Chuongtruyen::where('id_truyen',$truyen->id)->search($search_chapter)->paginate(10);

                $page_limit = 4;
                $half_total_links = floor($page_limit / 2);
                    $from = $chuong->currentPage() - $half_total_links;
                    $to = $chuong->currentPage() + $half_total_links;
                    if ($chuong->currentPage() < $half_total_links) {
                       $to += $half_total_links - $chuong->currentPage();
                    }
                    if ($chuong->lastPage() - $chuong->currentPage() < $half_total_links) {
                        $from -= $half_total_links - ($chuong->lastPage()- $chuong->currentPage());
                    }
                return view('frontend.pages.pagination-search-chapter',compact('chuong','from','to','truyen'))->render();
            }
            // Sự kiện đếm lượt xem 
        event(new ViewCount($truyen));
        return view('frontend.pages.viewtruyen',compact('truyen','chuong','from','to','tacgia_truyen','truyenhot_sort_today','truyenhot_sort_thisMonth','truyenhot_sort_all'));
    }
    public function phanloai($slug_phanloai)
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

        if ($slug_phanloai =='duoi-100-chuong') {
            $truyen = Truyen::join('chuongtruyens','chuongtruyens.id_truyen','=','truyens.id')->havingraw('count(chuongtruyens.id_truyen) <= 100')->orderBy('created_at','desc')->groupBy('chuongtruyens.id_truyen')->select([DB::raw('count(chuongtruyens.id_truyen) as chương_truyện'),'truyens.*'])->paginate(10);
        }
        if($slug_phanloai=='100-500-chuong'){
            $truyen = Truyen::join('chuongtruyens','chuongtruyens.id_truyen','=','truyens.id')->havingraw('count(chuongtruyens.id_truyen) <= 500')->havingraw('count(chuongtruyens.id_truyen) > 100')->orderBy('created_at','desc')->groupBy('chuongtruyens.id_truyen')->select([DB::raw('count(chuongtruyens.id_truyen) as chương_truyện'),'truyens.*'])->paginate(10);
        }
        if ($slug_phanloai=='500-1000-chuong') {
            $truyen = Truyen::join('chuongtruyens','chuongtruyens.id_truyen','=','truyens.id')->havingraw('count(chuongtruyens.id_truyen) < 1000')->havingraw('count(chuongtruyens.id_truyen) > 500')->orderBy('created_at','desc')->groupBy('chuongtruyens.id_truyen')->select([DB::raw('count(chuongtruyens.id_truyen) as chương_truyện'),'truyens.*'])->paginate(10);
        }
        if ($slug_phanloai=='tren-1000-chuong') {
            $truyen = Truyen::join('chuongtruyens','chuongtruyens.id_truyen','=','truyens.id')->havingraw('count(chuongtruyens.id_truyen) >= 1000')->orderBy('created_at','desc')->groupBy('chuongtruyens.id_truyen')->select([DB::raw('count(chuongtruyens.id_truyen) as chương_truyện'),'truyens.*'])->paginate(10);
        }

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
        return view('frontend.pages.phanloai',compact('truyen','slug_phanloai','from','to','truyenhot_sort_thisMonth','truyenhot_sort_today','truyenhot_sort_all'));
    }
    public function tacgia($slug_tacgia)
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

        $tacgia = Tacgia::where('slug',$slug_tacgia)->first();
        $name_tacgia=$tacgia->name;
        $truyen = $tacgia->tacgia_truyen()->paginate(10);
        return view('frontend.pages.tacgia',compact('truyen','name_tacgia','truyenhot_sort_all','truyenhot_sort_thisMonth','truyenhot_sort_today'));
    }
}