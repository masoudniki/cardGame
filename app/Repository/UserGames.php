<?php

namespace App\Repository;

use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserGames
{
    public static function updateUserStatus(Game $game,$user,$status){
        return DB::table("games_players")->where("game_id","=",$game->id)
            ->where("user_id",'=',$user->id)
            ->update(['status'=>$status]);
    }
}
