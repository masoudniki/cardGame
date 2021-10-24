<?php

namespace App\Listeners\JoinListeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class UserJoinedGameListener
{
    public $event;
    public function construct($event){
        $this->event=$event;
    }
    public function handle()
    {

    }
}
