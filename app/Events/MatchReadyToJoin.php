<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class MatchReadyToJoin implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $game;
    private ?Collection $players;

    public function __construct($game)
    {

        $this->game=$game;
        $this->players=$game->GamePlayers;
    }
    public function broadcastOn()
    {
        $channels=[];
        foreach($this->players as $player){
            $channels[]=new PresenceChannel('.user.'.$player->id);
        }
        return $channels;
    }
    public function broadcastAs(){
        return "MatchIsReadyToJoin";
    }
    public function broadcastWith(){
        return [
            "game_id"=>$this->game_id,
        ];
    }
}
