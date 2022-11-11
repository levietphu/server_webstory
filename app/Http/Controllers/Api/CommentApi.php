<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use DB;

class AuthApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $comments_user = Comment::where("id_truyen",$req->id_truyen)->where('id_parent',0)->orderby("created_at",'desc')->get();
        // dd($comments_user);
    }
}