<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tacgia;
use App\Models\Truyen;

class AuthorApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
      $author = Truyen::join('tacgias','tacgias.id','=','truyens.id_tacgia')->join('theloai_truyens','theloai_truyens.id_truyen','=','truyens.id')
        ->join('theloais','theloais.id','=','theloai_truyens.id_theloai')->groupby('truyens.id')->orderby('truyens.created_at','desc')->where('truyens.status',1)->where('tacgias.slug', $req->slug)->select('truyens.*','theloais.name as nameTheloai')->get();
        $name_author = Tacgia::where("slug",$req->slug)->first()->name;
        return ['success'=>true,
                'status'=>200,
                'author' => $author,
                "name_author"=>$name_author
                ];
    }

   
   
}