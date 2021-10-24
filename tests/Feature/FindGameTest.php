<?php

namespace Tests\Feature;

use App\Events\MatchWasFound;
use App\Jobs\FindGame;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Tests\traits\PreparingEnv;

class FindGameTest extends TestCase
{
    use RefreshDatabase,PreparingEnv;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_find_game_when_4_users_in_the_queue()
    {
        Event::fake();
        $this->addUsersToSearchingQueue(User::factory(10)->create());
        $gameFinder=new FindGame();
        $gameFinder->handle();
        Event::assertDispatched(MatchWasFound::class);
    }
}
