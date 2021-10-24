<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class UserJoinedListener
{
    public function handle($event)
    {
        $this->user_joined($event->socketId,optional($event->user)->user_id);
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
