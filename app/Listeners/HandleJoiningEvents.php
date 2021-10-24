<?php

namespace App\Listeners;

use App\Listeners\JoinListeners\UserJoinedGameListener;
use App\Listeners\JoinListeners\UserJoinedListener;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class HandleJoiningEvents
{
    public array $joinsListener=[
        'user'=>UserJoinedListener::class,
        'game'=>UserJoinedGameListener::class

    ];
    public ?User $user;
    public function handle($event)
    {
        $suitableHandler=$this->getEventHandler($event->channelName);
        if($suitableHandler){
            app()->make($suitableHandler,['event'=>$event])->handle();
        }

    }
    private function getEventHandler($channelName){
        [$channelType,$event,$id]=explode(".",$channelName);
        return $this->joinsListener[$event] ?? false;
    }
}
