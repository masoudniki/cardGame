<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class Game
{
    public static function changeGameStatus($game_id,$status){
        return DB::table("games")->where("id","=",$game_id)->update(["status"=>"$status"]);
    }
}
