<?php

namespace App\Events;

use App\Game\Game;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class MatchWasFound implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels,InteractsWithQueue;

    public $game;
    private Collection $palyers;

    public function __construct($game,$players)
    {
        $this->game=$game;
        $this->palyers=$players;
    }

    public function broadcastOn()
    {
        $channels=[];
        foreach($this->palyers as  $player){
            $channels[]=new PresenceChannel('.user.'.$player->id);
        }
        return $channels;
    }
    public function broadcastAs(){
        return "MatchFound";
    }
    public function broadcastWith(){
        return [
            "game_id"=>$this->game_id,
        ];

    }

}
