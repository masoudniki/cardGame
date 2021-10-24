<?php

namespace App\Listeners\JoinListeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class UserJoinedListener
{
    public $event;
    public function __construct($event){
        $this->event=$event;
    }
    public function handle()
    {
        $this->user_joined($this->event->socketId,optional($this->event->user)->user_id);
    }
    public function user_joined($socket_id,$user_id=null){
        if($user=User::query()->find($user_id)){
            $user->update(
                [
                    "socket_id"=>$socket_id,
                    "isOnline"=>true
                ]
            );
        };
    }




}
