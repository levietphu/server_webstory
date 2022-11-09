<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use App\Models\Chuongtruyen;
use App\Models\Truyen;

class ReadBook
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
        $key = 'reading.'.$request->slug_truyen;
        Session::put($key,$request->slug_chapter);
        return $next($request);
    }
}
