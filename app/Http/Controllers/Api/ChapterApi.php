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

class ChapterApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getChapterStory(Request $req)
    {
        $story = Truyen::where('slug',$req->slug)->first();
        $keyword = $req->keyword;
        $orderby = $req->orderby;

        $chapter = $story->chuong()->where('chapter_number','like','%'.$keyword.'%')->orderby('created_at',$orderby)->select('id','name_chapter','chapter_number','slug','coin','created_at')->paginate(20);

        if(!$req->id_user){
            return ['success'=>true,
            'status'=>200,
            'chapter' => $chapter
            ];
        }else{
            $check = json_decode(json_encode($chapter));
            foreach ($chapter as $key=> $value) {
            $check->data[$key]->bought =$value->getChapterPersonal()->where("users_chuongtruyens.id_user",$req->id_user)->where("users_chuongtruyens.bought",1)->first();
            }
            $chapter = $check;
            return ['success'=>true,
            'status'=>200,
            'chapter' =>$chapter
            ];

        }
        
    }
    
     public function buyChapter(Request $req)
    {
        if($req->id_user){
            $user = User::find($req->id_user);
            $truyen = Truyen::where('slug',$req->slug_story)->first();
            $chuong = Chuongtruyen::where('id_truyen', $truyen->id)->where('slug', $req->slug)->first();
            $user_chuong_vip = Users_chuongtruyen::where("id_chuong",$chuong->id)->where("id_user",$user->id)->where("bought",1)->first();
            if($user->coin - $chuong->coin>0 && is_null($user_chuong_vip)){
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
                ];
            }
            return [
                    'success'=>false,
                    'status'=>400,
                    'data' => [
                        'hasMores'=>"Xu của bạn không đủ. Vui lòng nạp thêm !"
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