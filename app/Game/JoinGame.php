<?php

namespace App\Game;



class JoinGame
{
    public static function canJoinGame($user,$game_id):bool{
         $game=\App\Models\Game::find($game_id);
         return $game && static::doesUserHasAccessToGame($game,$user) && static::doesUsersAcceptedTheGame($game);
    }
    public static function doesUserHasAccessToGame(\App\Models\Game $game,$user){
        return (bool)$game->GamePlayers()->where("user_id","=",$user->id)->first();
    }
    public static function doesUsersAcceptedTheGame(\App\Models\Game $game,$user){
        return (bool)$game->GamePlayers()->where("games_players.status","!=","ready")->get()->count()==4;
    }
}
