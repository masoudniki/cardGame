<?php

namespace App\Providers;

use App\Events\UserJoined;
use App\Listeners\ConnectionClosedListener;
use App\Listeners\HandleJoiningEvents;
use App\Listeners\UserJoinedListener;
use BeyondCode\LaravelWebSockets\Events\ConnectionClosed;
use BeyondCode\LaravelWebSockets\Events\SubscribedToChannel;
use BeyondCode\LaravelWebSockets\Events\UnsubscribedFromChannel;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SubscribedToChannel::class=>[
            HandleJoiningEvents::class
        ],
        UnsubscribedFromChannel::class=>[
        ],
        ConnectionClosed::class=>[
            ConnectionClosedListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
