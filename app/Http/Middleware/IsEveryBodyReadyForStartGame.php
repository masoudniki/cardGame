<?php

namespace App\Http\Middleware;

use App\Events\MatchReadyToJoin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IsEveryBodyReadyForStartGame
{
    public function handle(Request $request, Closure $next)
    {
        $response=$next($request);
        if($this->areOtherPlayersReady($request)){
            MatchReadyToJoin::dispatch($request->route()->parameter("game"));
        }
        return $response;

    }
    public function areOtherPlayersReady($request):bool{
        $game=$request->route()->parameter("game");
        return $game->GamePlayers()->where('games_players.status','ready')->get()->count() ==4;
    }
}
