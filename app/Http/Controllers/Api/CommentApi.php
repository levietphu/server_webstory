<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Truyen;
use DB;

class CommentApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $story = Truyen::where("slug",$req->slug)->first();

        // Hiển thị comment
        $check_comment = Comment::where("id_truyen",$story->id)->where('id_parent',0)->where('status',1)->orderby("created_at",'desc')->paginate(1);
        $comments_story = json_decode(json_encode($check_comment));

        foreach ($check_comment as $key => $value) {
            $comments_story->data[$key]->user = $value->user_comment()->select("id","name")->first();
            $comments_story->data[$key]->user->roles = $comments_story->data[$key]->user->getRole()->select("roles.id","roles.name")->get();
        }
        
        return [
            "success"=>true,
            "status"=>200,
            "comments_story"=>$comments_story,
        ];
    }

    public function children(Request $req)
    {
        $story = Truyen::where("slug",$req->slug)->first();

        $check_children= Comment::where("id_truyen",$story->id)->where('id_parent',"!=",0)->where('status',1)->get();
        $children_comments = json_decode(json_encode($check_children));
        foreach ($check_children as $key => $value) {
            $children_comments[$key]->user=$value->user_comment()->select("id","name")->first();
            $children_comments[$key]->user->roles=$children_comments[$key]->user->getRole()->select("roles.id","roles.name")->get();
        }
        return [
            "success"=>true,
            "status"=>200,
            "children_comments"=>$children_comments,
        ];
    }

    public function post_comment(Request $req)
    {
         $story = Truyen::where("slug",$req->slug)->first();
            //post comment
         try{
            if($req->content || $req->reply_content){
                DB::beginTransaction();

                $comment = new Comment;
                $comment ->id_user = $req->id_user;
                $comment ->id_truyen = $story->id;
                $comment ->content = !$req->content?$req->reply_content:$req->content;
                $comment ->id_parent = $req->id_parent;
                $comment->save();

                DB::commit();
                return [
                    "success" => true,
                    "status" => 200,
                    "message" =>"Thêm comment thành công"
                ];
            }
        }catch(\Exception $exception){
            DB::rollback();
            Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
            return abort(500,"Lỗi hệ thống");
        }

    }
}