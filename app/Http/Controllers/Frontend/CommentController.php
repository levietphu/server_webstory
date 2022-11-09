<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Auth;

class CommentController extends Controller
{
    public function comment(Request $req)
    {
        if ($req->ajax()) {
            if ($req->content) {
                $new_comment = new Comment;
                $new_comment->id_truyen = $req->id_truyen;
                $new_comment->id_user = Auth::id();
                $new_comment ->content =$req->content;
                $new_comment->save();
                
            }
            if ($req->children_content) {
                $new_comment = new Comment;
                $new_comment->id_truyen = $req->id_truyen;
                $new_comment->id_user = Auth::id();
                $new_comment ->content =$req->children_content;
                $new_comment ->id_parent =$req->id_comment;
                $new_comment->save();
            }
            $comment = Comment::where('id_truyen',$req->id_truyen)->orderby('created_at','desc')->where('id_parent',0)->get();
                return view('frontend.pages.comment',compact('comment'));
        }
    }
    
}
