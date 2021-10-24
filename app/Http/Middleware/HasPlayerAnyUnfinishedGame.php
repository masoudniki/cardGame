<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasPlayerAnyUnfinishedGame
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
        if(!$this->hasUserAnyUnfinishedGame()){
            return $next($request);
        };
        return response()->json([
            "data"=>[
                "message"=>__("game.you_have_unfinished_game")
            ]
        ],403);
    }

    public function hasUserAnyUnfinishedGame()
    {
        return Auth::user()->games()->where("games.status", "=", "running")->first();
    }
}
