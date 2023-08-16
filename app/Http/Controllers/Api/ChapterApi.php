<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truyen;
use App\Models\Chuongtruyen;
use App\Models\User;
use App\Models\Users_chuongtruyen;
use App\Models\BookMark;
use App\Models\Comment;
use Carbon\Carbon;
use App\Events\ViewCount;
use DB;
use Log;

class ChapterApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewChapter(Request $req)
    {

        $truyen = Truyen::where('slug',$req->slug_story)->select("id","name")->first();
        $chuong = Chuongtruyen::where('id_truyen', $truyen->id)->where('slug', $req->slug)->first();
        $user_chuong_vip = Users_chuongtruyen::where("id_chuong",$chuong->id)->where("bought",1)->where('id_user',$req->id_user)->first();
        $chapter_prev = Chuongtruyen::where('id_truyen',$truyen->id)->where('id','<',$chuong->id)->orderby('created_at','desc')->first();
        $chapter_next = Chuongtruyen::where('id_truyen',$truyen->id)->where('id','>',$chuong->id)->orderby('created_at','asc')->first();

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

        
        if(!is_null($user_chuong_vip) || $chuong->coin==0){
            return [
                'success'=>true,
                'status'=>200,
                'data' => [
                    'items' => [
                        'chuong'=>$chuong,
                        'truyen'=>$truyen,
                        "vip"=>false,
                        'slug_prev'=>$slug_prev,
                        'slug_next'=>$slug_next,
                    ]
                ]
            ];
        }

        if($chuong->coin>0 && is_null($user_chuong_vip)){
            return [
                'success'=>true,
                'status'=>200,
                'data' => [
                    'items' => [
                        'chuong'=>["coin"=>$chuong->coin,"name_chapter"=>$chuong->name_chapter,'slug'=>$chuong->slug,"chapter_number"=>$chuong->chapter_number],
                        'truyen'=>$truyen,
                        'vip'=>true,
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
                try{
                    DB::beginTransaction();
                    $user_chuong = new Users_chuongtruyen();
                    $user_chuong->id_user=$req->id_user;
                    $user_chuong->id_chuong=$chuong->id;
                    $user_chuong->id_truyen=$truyen->id;
                    $user_chuong->bought=1;
                    $user_chuong->save();

                    $bookmark = new BookMark();
                    $bookmark->id_user=$req->id_user;
                    $bookmark->id_chuong=$chuong->id;
                    $bookmark->id_truyen=$truyen->id;
                    $bookmark->bought=1;
                    $bookmark->save();
                    DB::commit();
                    
                }catch(\Exception $exception){
                    DB::rollback();
                    Log::error('message:'.$exception->getMessage().'Line'.$exception->getLine());
                }
                
                if($req->id_user === $truyen->id_user){
                    return [
                        "success"=>true,
                        "status"=>200,
                        "message" => "Là dịch giả nên không mất xu"
                    ];
                }

                $user->coin = $user->coin - $chuong->coin;
                $user->save();

                $user_posted = User::find($truyen->id_user);
                $user_posted->coin = $user_posted->coin + $chuong->coin;
                $user_posted->save();

                return [
                    'success'=>true,
                    'status'=>200,
                    "message"=>"Mua thành công"
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

    public function add_bookmark(Request $req)
    {
        if(!$req->id_user){
            return [
                "success"=>false,
                "status"=>400,
                "message"=>"Vui lòng đăng nhập để thêm vào tủ sách"
            ];
        }

        $truyen = Truyen::where('slug',$req->slug_story)->first();
        $chuong = Chuongtruyen::where('id_truyen', $truyen->id)->where('slug', $req->slug)->first();
        $user_chuong_vip = Users_chuongtruyen::where("id_chuong",$chuong->id)->where("bought",1)->where('id_user',$req->id_user)->first();

        if($chuong->coin==0 || $user_chuong_vip){
            $user_chuong = new BookMark();
            $user_chuong->id_user=$req->id_user;
            $user_chuong->id_chuong=$chuong->id;
            $user_chuong->bought=0;
            $user_chuong->id_truyen=$truyen->id;
            $user_chuong->save();

            return [
                "success"=>true,
                "status"=>200,
                "message"=>"Thêm vào tủ sách thành công",
           ];
        }
       return [
        "success"=>false,
        "status"=>400,
        "message"=>"Chưa mua chương này,Vui lòng mua và tự động sẽ thêm vào tủ sách"
       ];
    }

    public function remove_bookmark(Request $req)
    {
        BookMark::where("id_truyen",$req->id_story)->delete();
        return [
            "success"=>true,
            "status"=>200,
            "message"=>"Xóa truyện khỏi tủ sách thành công"
        ];
    }
}