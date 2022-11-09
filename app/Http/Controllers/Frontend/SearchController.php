<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truyen;
use Carbon\Carbon;
use DB;
class SearchController extends Controller
{
    public function post_search(Request $req)
    {
        Carbon::setLocale('vi');
        $truyen = Truyen::where('name','like','%'.$req->tukhoa.'%')->get();
        if($truyen->count()>3)
        {
            $truyen = Truyen::where('name','like','%'.$req->tukhoa.'%')->limit(3)->get();
            $view_more= '<a class="col-md-12 pt-10 pb-10 pl-10 hover-chapter border-bottom color-black" href="'.route('search').'?tukhoa='.$req->tukhoa.'">Xem thêm</a>';
        }else{
            $truyen = Truyen::where('name','like','%'.$req->tukhoa.'%')->limit(2)->get();
            $view_more= '';
        }
        $data='';    
            foreach ($truyen as $value) {
                $theloai='';
                foreach ($value->truyen as $loai) {
                    $theloai.='<button class="btn btn-outline-secondary mr-10">'.$loai->name.'</button>';
                }
                    $data.='<a class="col-md-12 pt-10 pb-10 pl-10 hover-chapter border-bottom color-black" href="'.route('view',$value->slug).'" title="'.$value->name.'">
                            <div class="row">
                                <div class="col-3 col-md-2 col-lg-1"><span class="has-text-weight-bold pr-2"><img src="./public/uploads/'.$value->image.'" width="60" height="90" /></div>
                                <div class="col-9 col-md-10 col-lg-11">
                                    <h4 auto-update="true">'.$value->name.'</h4>
                                    '.$theloai.'
                                </div>
                            </div>
                        </a>';
            }
        echo '<div class="back-tran card">'
                .$data.$view_more.'
            </div>';
    }
    public function search(Request $req)
    {
        if ($req->tukhoa =='') {
            $tukhoa=$_GET['tukhoa'];
        }else{
            $tukhoa = $req->tukhoa;
        }
        $truyen = Truyen::where('name','like','%'.$req->tukhoa.'%')->paginate(10);
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

        return view('frontend.pages.search',compact('tukhoa','truyenhot_sort_today','truyenhot_sort_thisMonth','truyenhot_sort_all','truyen','to','from'));
    }
}
