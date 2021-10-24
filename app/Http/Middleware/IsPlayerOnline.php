<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsPlayerOnline
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
        if(Auth::user()->isOnline){
            return $next($request);
        }
        return response()->json([
            "data"=>[
                "message"=>__('game.socket_connection_not_established')
            ]
        ],403);

    }
}
