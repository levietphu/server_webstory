<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;

class AddVisitor
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
        $ip_address=$request->ip();
        $visit = Visitor::where('ip_address',$ip_address)->first();
        if (empty($visit)) {
            $visit = new Visitor;
            $visit->ip_address=$ip_address;
            $visit->save();
        }
        return $next($request);
    }
}
