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
}