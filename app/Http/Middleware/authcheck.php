<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class authcheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        var_dump(Auth::guard('api')->user());
        if(!Auth::guard('api')->check()){ // kalau tidak menemukan user yang login maka akan return json failed. kalau ketemu ya diproses ke next.
            return response()->json([
                "message" => "failed, user not logged in"
            ],400);    
         }
         return $next($request);
    }
}
