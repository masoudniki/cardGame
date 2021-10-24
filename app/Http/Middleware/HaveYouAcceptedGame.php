<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HaveYouAcceptedGame
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
        if(!$this->doesUserAcceptedTheGame($request)){
            return $next($request);
        }
        return response()->json(["data"=>
            [
                "message"=>"you have already accepted the game"
            ]
        ],403);
    }
    public function doesUserAcceptedTheGame($request): bool
    {
        $game=$request->route()->parameter("game");
        return (bool)$game->GamePlayers()->where("user_id","=",Auth::user()->id)->where('games_players.status','=','ready')->first();

    }
}
