<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsEveryBodyReadyForStartGame
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
        if($this->areOtherPlayersReady($request)){

        }
        return $next($request);
    }
    public function areOtherPlayersReady($request):bool{
        $game=$request->route()->parameter("game");
        return $game->GamePlayers()->where('user_id','!=',Auth::user()->id)->where('games_players.status','ready')->get()->count() ==3;
    }
}
