<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;

class ViewCount
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
        $truyen = $this->checkSessionViews();
        if (!is_null($truyen)) {
            $truyen = $this->checkTime($truyen);
            $this->sessionPutViews($truyen);
        }
        return $next($request);
    }
    private function checkSessionViews()
    {
        return Session::get('views',null);
    }
    private function checkTime($truyen)
    {
        $now=Carbon::now();
        return array_filter($truyen, function ($timestamp) use ($now)
        {
            return $timestamp->diffInMinutes($now)<3;
        });
    }

    private function sessionPutViews($truyen)
    {
        return Session::put('views',$truyen);
    }
}
