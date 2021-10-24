<?php

namespace App\Http\Controllers;

use App\Jobs\FindGame;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    public function findGame(): \Illuminate\Http\JsonResponse
    {
        Auth::user()->searchingQueue()->create();
        FindGame::dispatch();
        return response()->json([
            "data"=>[
                "message"=>__("game.you_have_successfully_added_to_searching_queue")
            ]
        ]);
    }
    public function acceptGame(Game $game){
        $game->GamePlayers()->where("user_id","=",Auth::user()->id)->update([
            "status"=>"ready"
        ]);
        $howManyPlayerJoined=$game->GamePlayers()->where("status","=","ready")->count();
        return response()->json([
            "data"=>[
                "message"=>"successfully joined",
                "how_many_player_joined"=>$howManyPlayerJoined
            ]
        ]);
    }
}
