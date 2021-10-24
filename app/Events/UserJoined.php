<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserJoined
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $channel;
    public string $user_id;
    public string $socketId;
    public function __construct($channel,$userId,$socketId)
    {
        $this->channel=$channel;
        $this->user_id=$userId;
        $this->socketId=$socketId;
    }
}
