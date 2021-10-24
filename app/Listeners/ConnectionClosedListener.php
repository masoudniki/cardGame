<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class ConnectionClosedListener
{
    public ?User $user;
    public function handle($event)
    {
        $this->user=$this->getUser($event->socketId);
        $this->connection_closed();
        $this->remove_from_searching_queue();
    }
    public function getUser($socket_id){
        return User::query()->where("socket_id",$socket_id)->first();
    }
    public function connection_closed(){
        if($this->user){
            $this->user->update(
                [
                    "socket_id"=>"",
                    "isOnline"=>false
                ]
            );
        };
    }
    public function remove_from_searching_queue(){
        if($this->user->isUserSearching()){
            $this->user->searchingQueue->delete();
        }
    }
}
