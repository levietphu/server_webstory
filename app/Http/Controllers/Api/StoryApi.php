<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truyen;
use App\Models\Chuongtruyen;
use App\Models\User;
use App\Models\Users_chuongtruyen;;
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
        $keyword = $req->keyword;
        $orderby = $req->orderby;

        $truyen = json_decode(json_encode($afterView));

        $truyen->theloais = $afterView->truyen;
        $truyen->tacgia = $afterView->tacgia;
        $truyen->dichgia = $afterView->dichgia;
        $truyen->chuongs = $afterView->chuong()->where('chapter_number','like','%'.$keyword.'%')->orderby('created_at',$orderby)->select('name_chapter','chapter_number','slug','coin','created_at')->paginate(20);

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

        $chapter_prev = Chuongtruyen::where('id_truyen',$truyen->id)->where('id','<',$chuong->id)->orderby('created_at','desc')->first();
        $chapter_next = Chuongtruyen::where('id_truyen',$truyen->id)->where('id','>',$chuong->id)->orderby('created_at','asc')->first();
        if($req->id_user && $chuong->coin==0){
            $user_chuong = new Users_chuongtruyen();
            $user_chuong->id_user=$req->id_user;
            $user_chuong->id_chuong=$chuong->id;
            $user_chuong->bought=0;
            $user_chuong->id_truyen=$truyen->id;
            $user_chuong->created_at=Carbon::now();
            $user_chuong->updated_at=Carbon::now();
            $user_chuong->save();
        }

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

        $all_chuongtruyen = Chuongtruyen::where('id_truyen',$truyen->id)->where('chapter_number','like','%'.$keyword.'%')->orderby('created_at',$orderby)->paginate(20);
        $userChapter = Users_chuongtruyen::get();
        $check = false;
        foreach ($userChapter as $value) {
            if($value->id_chuong==$chuong->id && $req->id_user==$value->id_user && $value->bought==1){
                $check=true;
            }
        }

        if($check || $chuong->coin==0){
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
            
        }elseif($chuong->coin>0 && !$check){
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

    public function buyChapter(Request $req)
    {
        if($req->id_user){
            $user = User::find($req->id_user);
            $truyen = Truyen::where('slug',$req->slug_story)->first();
            $chuong = Chuongtruyen::where('id_truyen', $truyen->id)->where('slug', $req->slug)->first();
            if($user->coin - $chuong->coin>0){
                $user->coin = $user->coin - $chuong->coin;
                $user->save();

                $user_chuong = new Users_chuongtruyen();
                $user_chuong->id_user=$req->id_user;
                $user_chuong->id_chuong=$chuong->id;
                $user_chuong->id_truyen=$truyen->id;
                $user_chuong->bought=1;
                $user_chuong->created_at=Carbon::now();
                $user_chuong->updated_at=Carbon::now();
                $user_chuong->save();

                return [
                    'success'=>true,
                    'status'=>200,
                    'data' => [
                        'items'=>$chuong->content
                    ]
                ];
            }
            return [
                    'success'=>false,
                    'status'=>400,
                    'data' => [
                        'hasMores'=>"Vui lòng nạp tiền"
                    ]
                ];
        }

        return  [
                    'success'=>false,
                    'status'=>400,
                    'data' => [
                        'hasMores'=>"Vui lòng Đăng nhập"
                    ]
                ];
    }

}