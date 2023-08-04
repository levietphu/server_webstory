<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Theloai;
use App\Models\Truyen;
use App\Models\Translator;
use App\Models\Config;
use DB;

class MultiApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $slug = $req->slug;
        $page = $req->page;

        if(!$slug){
            return rebort(400,"error missing request");
        }

        $cate = Theloai::where('slug',$slug)->first();
        if(!$cate){
            return rebort(404,"Not found");
        }

        $check = Truyen::join('chuongtruyens','truyens.id','=','chuongtruyens.id_truyen')->join('theloai_truyens','theloai_truyens.id_truyen','=','truyens.id')->join('theloais','theloais.id','=','theloai_truyens.id_theloai')
        ->where('truyens.status',1)->where('theloais.slug',$slug)
        ->groupby('chuongtruyens.id_truyen')->orderby(DB::raw('max(chuongtruyens.created_at)'), 'desc')
        ->select('truyens.*')
        ->paginate(10);
        if($page > $check->lastPage() || $page <1 && isset($page)){
            return [
                'success'=>false,
                'data' => ["hasMore"=> false]
            ];
        };
        $cateStory = json_decode(json_encode($check));
        foreach ($check as $key => $value) {
            $cateStory->data[$key]->theloais = $value->truyen;
            $cateStory->data[$key]->tacgia = $value->tacgia;
            $cateStory->data[$key]->chuong = $value->chuong()->orderBy('created_at','desc')->first();
        }
        return ['success'=>true,'status' => 200,'data' => [
            'items'=>$cateStory,
            'name'=>$cate->name
        ]
            
        ];
    }
    public function list(Request $req)
    {
        $slug = $req ->slug;
        $page = $req->page;
        if(!$slug){
            return [
                'success'=>false,
                'status'=>401,
                'data' => ['hasMore'=>"error missing request"]
            ];
        }
        if($slug == 'truyen-vip'){
            $check = Truyen::orderby('view_count','desc')->where('vip',1)->where('status',1)->paginate(30);
        }
        if($slug =='truyen-mien-phi'){
            $check = Truyen::where('vip',0)->where('truyens.status',1)->paginate(10);
        }
        if($slug =='truyen-full'){
            $check = Truyen::where('full',1)->where('truyens.status',1)->paginate(10);
        }
        if($slug =='truyen-moi'){
            $check = Truyen::join('chuongtruyens','truyens.id','=','chuongtruyens.id_truyen')
            ->where('truyens.status',1)
            ->groupby('chuongtruyens.id_truyen')->orderby(DB::raw('max(chuongtruyens.created_at)'), 'desc')
            ->select('truyens.*')
            ->paginate(10);
        }
        if($slug != 'truyen-vip' && $slug != 'truyen-full' && $slug != 'truyen-mien-phi' && $slug != 'truyen-moi' ){
            return [
                'success'=>false,
                'status'=>404,
                'data' => ['hasMore'=>"Not found"]
            ];
        }
        if($slug!="truyen-vip" && $page > $check->lastPage() || $page <1 && isset($page)){
            return [
                'success'=>false,
                'data' => ["hasMore"=> false]
            ];
        };
            $listStory = json_decode(json_encode($check));
            foreach ($check as $key => $value) {
                $listStory->data[$key]->theloais = $value->truyen;
                $listStory->data[$key]->tacgia = $value->tacgia;
                $listStory->data[$key]->chuong = $value->chuong()->orderBy('created_at','desc')->first();
            }
       
        
        return ['success'=>true,'data' => [
            'items'=>$listStory,
        ]
            
        ];
    }
     public function translator(Request $req)
    {
        $slug = $req->slug;
        if(!$slug){
            return [
                'success'=>false,
                'status'=>401,
                'data' => ['hasMore'=>"error missing request"]
            ];
        }

        $translator = Translator::where('slug',$slug)->first();

        if(!$translator){
            return [
                'success'=>false,
                'status'=>404,
                'data' => ['hsMore'=>"Not Found"]
            ];
        }
        
        $translatorStory = Truyen::join('translators','translators.id','=','truyens.id_trans')->join('theloai_truyens','theloai_truyens.id_truyen','=','truyens.id')
        ->join('theloais','theloais.id','=','theloai_truyens.id_theloai')->groupby('truyens.id')->orderby('truyens.created_at','desc')->where('truyens.status',1)->where('translators.slug', $slug)->select('truyens.*','theloais.name as nameTheloai')->get();
        
        return ['success'=>true,'status'=>200,'data' => [
            'items'=>$translatorStory
        ]
            
        ];
    }
}
