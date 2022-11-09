<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Chuongtruyen;
use App\Models\Truyen;

class Chapter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $slug_truyen =$request->slug_truyen;
        $slug_chapter =$request->slug_chapter;
        $truyen = Truyen::where('slug',$slug_truyen)->first();
        $chuongtruyen = Chuongtruyen::where('id_truyen',$truyen->id)->where('slug',$slug_chapter)->first();
        // dd(str_replace('chuong-', '', $slug_chapter)-1);
        if ($chuongtruyen==null) {
            return redirect()->to($truyen->slug);
        }
        return $next($request);
    }
}
