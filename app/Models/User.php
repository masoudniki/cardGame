<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        "socket_id",
        "isOnline"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function games(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Game::class,"games_players","user_id","game_id")->withTimestamps();
    }
    public function searchingQueue(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(SearchingUser::class,"user_id","id");
    }
    public function isUserOnline(){
        return $this->isOnline;
    }
    public function isUserSearching(){
        return (boolean)$this->hasOne(SearchingUser::class,"user_id","id")->first();
    }
}
