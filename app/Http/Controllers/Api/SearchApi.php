<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truyen;
use App\Models\Chuongtruyen;

class SearchApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $keyword = $req->keyword;

        $check = Truyen::where('name','like','%'.$keyword.'%')->get();

        $searchTruyen = json_decode(json_encode($check));
        foreach ($check as $key => $value) {
            $searchTruyen[$key]->theloais = $value->truyen;
        }

        return ['success'=>true,'status'=>200,'data' => [
         'items'=>$searchTruyen
     ]
 ];
}

public function searchChapter(Request $req)
{
    $keyword = $req->keyword;
    $id_story =$req->id_story;

    $searchChuong = Chuongtruyen::where('id_truyen',$id_story)->where(function($query) use ($keyword){
        $query->where('name_chapter', 'like', '%' . $keyword . '%')
        ->orWhere('chapter_number', 'like', '%' . $keyword . '%');
    })->select('name_chapter','chapter_number','slug','coin')->paginate(1);


    return ['success'=>true,'status'=>200,'data' => [
     'items'=>$searchChuong
 ]

];
}

}
