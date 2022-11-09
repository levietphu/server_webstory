<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Theloai;
use App\Models\Config;

class LayoutApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cates = Theloai::get();
        $logo_header = Config::where('type', 1)->where('slug','logo-header')->first();
        $logo_footer = Config::where('type', 1)->where('slug','logo-footer')->first();
        $khau_hieu = Config::where('type', 2)->where('slug','khau-hieu')->first();
        $link_apple = Config::where('type', 2)->where('slug','link-apple')->first();
        $link_androi = Config::where('type', 2)->where('slug','link-androi')->first();
        return ['success'=>true,'status'=>200,'data' => [
            'cates'=>$cates,
            'logo_header'=>$logo_header,
            'logo_footer'=>$logo_footer,
            'khau_hieu'=>$khau_hieu,
            'link_apple'=>$link_apple,
            'link_androi'=>$link_androi,
        ]
            
        ];
    }
    
}
