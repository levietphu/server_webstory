<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truyen;
use App\Models\Chuongtruyen;
use App\Models\User;
use App\Models\Users_chuongtruyen;
use App\Models\Comment;
use Carbon\Carbon;
use App\Events\ViewCount;
use DB;

class StoryApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStory(Request $req)
    {
        $afterView = Truyen::where('slug',$req->slug)->first();

        $truyen = json_decode(json_encode($afterView));

        $truyen->theloais = $afterView->truyen;
        $truyen->tacgia = $afterView->tacgia;
        $truyen->dichgia = $afterView->dichgia;
       
        $truyen->rank = Truyen::orderby('view_count','desc')->where('vip',1)->where('status',1)->limit(3)->select("id")->get();
        $truyen->chapter_one = Chuongtruyen::where("id_truyen",$afterView->id)->first();
        $truyen->total_chapter = $afterView->chuong()->count();

            return ['success'=>true,
            'status'=>200,
            'data' => [
                'items' => $truyen]
            ];        
    }
    public function addViewCount(Request $req)
    {
        $truyen = Truyen::where("slug",$req->slug)->first();
        
        event(new ViewCount($truyen));
        return [];
    }

    public function viewChapter(Request $req)
    {

        $keyword = $req->keyword;
        $orderby = $req->orderby;
        $truyen = Truyen::where('slug',$req->slug_story)->first();
        $chuong = Chuongtruyen::where('id_truyen', $truyen->id)->where('slug', $req->slug)->first();
        $user_chuong_vip = Users_chuongtruyen::where("id_chuong",$chuong->id)->where("bought",1)->where('id_user',$req->id_user)->first();
        $chapter_prev = Chuongtruyen::where('id_truyen',$truyen->id)->where('id','<',$chuong->id)->orderby('created_at','desc')->first();
        $chapter_next = Chuongtruyen::where('id_truyen',$truyen->id)->where('id','>',$chuong->id)->orderby('created_at','asc')->first();

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

        $check = Chuongtruyen::where('id_truyen',$truyen->id)->where('chapter_number','like','%'.$keyword.'%')->orderby('created_at',$orderby)->select("id","slug",'chapter_number',"name_chapter","created_at","coin")->paginate(20);
        $all_chuongtruyen = json_decode(json_encode($check));
        if($req->id_user){
            foreach ($check as $key=> $value) {
            $all_chuongtruyen->data[$key]->bought =$value->getChapterPersonal()->where("users_chuongtruyens.id_user",$req->id_user)->where("users_chuongtruyens.bought",1)->first();
            }
        }
        $userChapter = Users_chuongtruyen::get();

        if(!is_null($user_chuong_vip) || $chuong->coin==0){
            return [
                'success'=>true,
                'status'=>200,
                'data' => [
                    'items' => [
                        'chuong'=>$chuong,
                        'truyen'=>$truyen,
                        "vip"=>false,
                        'allChapter'=>$all_chuongtruyen,
                        'slug_prev'=>$slug_prev,
                        'slug_next'=>$slug_next,
                    ]
                ]
            ];
        }

        if($chuong->coin>0 && is_null($user_chuong_vip)){
            return [
                'success'=>false,
                'status'=>400,
                'data' => [
                    'items' => [
                        'chuong'=>["coin"=>$chuong->coin,"name_chapter"=>$chuong->name_chapter,'slug'=>$chuong->slug,"chapter_number"=>$chuong->chapter_number],
                        'truyen'=>$truyen,
                        'vip'=>true,
                        'allChapter'=>$all_chuongtruyen,
                        'slug_prev'=>$slug_prev,
                        'slug_next'=>$slug_next,
                    ]
                ]
            ];
        }
    }

    public function add_bookmark(Request $req)
    {
        if(!$req->id_user){
            return [
                "success"=>false,
                "status"=>400,
                "message"=>"Vui lòng đăng nhập để thêm vào tủ sách"
            ];
        }

        $truyen = Truyen::where('slug',$req->slug_story)->first();
        $chuong = Chuongtruyen::where('id_truyen', $truyen->id)->where('slug', $req->slug)->first();
        $user_chuong_vip = Users_chuongtruyen::where("id_chuong",$chuong->id)->where("bought",1)->where('id_user',$req->id_user)->first();
        $user_chuong = Users_chuongtruyen::all();

        if($user_chuong[count($user_chuong)-1]->id_chuong == $chuong->id){
            return [
                "success"=>false,
                "status"=>400,
                "message"=>"Chương này mới vừa thêm vào tủ sách"
            ];
        }

        if($chuong->coin==0 || $user_chuong_vip){
            $user_chuong = new Users_chuongtruyen();
            $user_chuong->id_user=$req->id_user;
            $user_chuong->id_chuong=$chuong->id;
            $user_chuong->bought=0;
            $user_chuong->id_truyen=$truyen->id;
            $user_chuong->save();

            return [
                "success"=>true,
                "status"=>200,
                "message"=>"Thêm vào tủ sách thành công",
           ];
        }
       return [
        "success"=>false,
        "status"=>400,
        "message"=>"Chưa mua chương này,Vui lòng mua và tự động sẽ thêm vào tủ sách"
       ];
    }
}