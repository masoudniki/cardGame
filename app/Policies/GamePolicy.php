<?php

namespace App\Policies;

use App\Models\Game;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GamePolicy
{
    use HandlesAuthorization;
    public function acceptGame(User $user,Game $game){
        return $game->GamePlayers()->where("user_id","=",$user->id)->get()->count() ==1;
    }
}
