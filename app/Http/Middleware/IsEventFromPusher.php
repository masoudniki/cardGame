<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IsEventFromPusher
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
        if($request->hasHeader("X-PUSHER-KEY") && $this->verifySignature($request))
        {
            return $next($request);
        }
        return abort(403,"you dont have access");
    }
    public function verifySignature(Request $request){
        return hash_equals(
            hash_hmac('sha256', $request->getContent(), config("websockets.apps.0.secret")),
            $request->header("X-PUSHER-KEY")
        );

    }
}
