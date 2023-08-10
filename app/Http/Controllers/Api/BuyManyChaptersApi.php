<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chuongtruyen;
use DB;

class BuyManyChaptersApi extends Controller
{
    public function create(Request $req)
    {
        dd((int)explode("-","chuong-1")[1]);
    }
}