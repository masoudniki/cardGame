<?php

namespace App\Http\Middleware;

use App\Events\MatchReadyToJoin;
use App\Game\GameStatus;
use App\Repository\Game;
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
            Game::changeGameStatus($request->route()->parameter("game")->id,GameStatus::WAITING_FOR_PLAYERS_TO_JOIN);
        }
        return $response;
    }
    public function areOtherPlayersReady($request):bool{
        $game=$request->route()->parameter("game");
        return $game->GamePlayers()->where('games_players.status','ready')->get()->count() ==4;
    }
}
