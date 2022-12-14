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
        $keyword = $req->keyword;
        $orderby = $req->orderby;

        $truyen = json_decode(json_encode($afterView));

        $truyen->theloais = $afterView->truyen;
        $truyen->tacgia = $afterView->tacgia;
        $truyen->dichgia = $afterView->dichgia;
        $truyen->chuongs = $afterView->chuong()->where('chapter_number','like','%'.$keyword.'%')->orderby('created_at',$orderby)->select('id','name_chapter','chapter_number','slug','coin','created_at')->paginate(20);

        if($req->id_user){
            if($req->content || $req->reply_content){
                $comment = new Comment;
                $comment ->id_user = $req->id_user;
                $comment ->id_truyen = $afterView->id;
                $comment ->content = is_null($req->content)?$req->reply_content:$req->content;
                $comment ->id_parent = $req->id_parent;
                $comment->save();
            }
        }

        $check_comment = Comment::where("id_truyen",$afterView->id)->where('id_parent',0)->orderby("created_at",'desc')->get();
        $comments_story = json_decode(json_encode($check_comment));

        foreach ($check_comment as $key => $value) {
            $comments_story[$key]->commet_childrens = $value->children_comment()->orderBy("created_at","desc")->get();
            $comments_story[$key]->user = $value->user_comment()->select("name")->first(); 

            $check_comment = json_decode(json_encode($comments_story[$key]->commet_childrens));

            foreach ($comments_story[$key]->commet_childrens as $index => $item) {
                $comments_story[$key]->commet_childrens[$index]->user= $item->user_comment()->select("name")->first();
            }
        }
        $truyen->comments_story = $comments_story;

        if(!$req->id_user){
            return ['success'=>true,
            'status'=>200,
            'data' => [
                'items' => $truyen]
            ];
        }else{
            $check = json_decode(json_encode($truyen->chuongs));
            foreach ($truyen->chuongs as $key=> $value) {
            $check->data[$key]->bought =$value->getChapterPersonal()->where("users_chuongtruyens.id_user",$req->id_user)->where("users_chuongtruyens.bought",1)->first();
            }
            $truyen->chuongs = $check;
            return ['success'=>true,
            'status'=>200,
            'data' => [
                'items' => $truyen]
            ];

        }
        
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
        if($req->id_user && ($chuong->coin==0 || $user_chuong_vip)){
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
            
        }elseif($chuong->coin>0 && is_null($user_chuong_vip)){
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
                        'hasMores'=>"Xu c???a b???n kh??ng ?????. Vui l??ng n???p th??m !"
                    ]
                ];
        }

        return  [
                    'success'=>false,
                    'status'=>411,
                    'data' => [
                        'hasMores'=>"Vui l??ng ????ng nh???p"
                    ]
                ];
    }

}