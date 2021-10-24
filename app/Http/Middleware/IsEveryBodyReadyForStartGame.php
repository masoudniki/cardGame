<?php

namespace App\Http\Middleware;

use App\Events\MatchReadyToJoin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsEveryBodyReadyForStartGame
{
    public function handle(Request $request, Closure $next)
    {
        if($this->areOtherPlayersReady($request)){
            MatchReadyToJoin::dispatch($request->route()->parameter("game"));
        }
        return $next($request);
    }
    public function areOtherPlayersReady($request):bool{
        $game=$request->route()->parameter("game");
        return $game->GamePlayers()->where('user_id','!=',Auth::user()->id)->where('games_players.status','ready')->get()->count() ==3;
    }
}
