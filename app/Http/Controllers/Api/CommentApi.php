<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
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
        $check = Comment::where("id_truyen",$req->id_story)->where('id_parent',0)->orderby("created_at",'desc')->get();
        $comments_story = json_decode(json_encode($check));

        foreach ($check as $key => $value) {
            $comments_story[$key]->commet_childrens = $value->children_comment()->orderBy("created_at","desc")->get();
            $comments_story[$key]->user = $value->user_comment()->select("name")->first(); 

            $check = json_decode(json_encode($comments_story[$key]->commet_childrens));

            foreach ($comments_story[$key]->commet_childrens as $index => $item) {
                $comments_story[$key]->commet_childrens[$index]->user= $item->user_comment()->select("name")->first();
            }
        }
        dd($comments_story);
        return [
            "success" => true,
            "status" => 200,
            "comments_story" => $comments_story
        ];
    }
}