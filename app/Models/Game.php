<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    protected $fillable=[
        "status",
        "hakem",
        "hokm"
    ];
    public function GamePlayers(){
        return $this->belongsToMany(User::class,"games_players","game_id","user_id")->withPivot('status','cards')->withTimestamps();
    }
}
