<?php

namespace Tests\Feature;

use App\Events\MatchReadyToJoin;
use App\Models\User;
use Facade\Ignition\Tabs\Tab;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class GameControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_can_find_game(){
        $user=User::factory(1)->create()->first();
        $this->actingAs($user);
        $this->post(route("game.find"))->assertStatus(200);
    }
    public function test_can_not_find_game_when_not_autheticated(){
        $this->post(route("game.find"))->assertStatus(401);
    }
    public function test_can_not_find_game_when_is_not_connected_to_socket(){
        $user=User::factory(1)->create()->first();
        $user->isOnline=false;
        $user->save();
        $this->actingAs($user);
        $this->post(route("game.find"))->assertStatus(403);
    }
    public function test_can_accept_game(){
        Event::fake();
        $users=User::factory(4)->create();
        $game=\App\Models\Game::factory(1)->create()->first();
        $users_id=$users->map(function ($item){return $item->id;})->toArray();
        $game->GamePlayers()->sync($users_id);
        $this->actingAs($users->first());
        $this->post(route("game.accept",["game"=>$game->id]))->assertStatus(200);
        Event::assertNotDispatched(MatchReadyToJoin::class);
    }
    public function test_throw_event_when_every_body_are_ready_in_the_game(){
        Event::fake();
        $users=User::factory(4)->create();
        $this->actingAs($users->first());
        $game=\App\Models\Game::factory(1)->create()->first();
        $users_id=$users->map(function ($item){return $item->id;})->toArray();
        $users_id=array_flip($users_id);
        foreach($users_id as $key=>$val){
            $users_id[$key]=['status'=>'ready'];
        }
        $users_id[1]=['status'=>'waiting-for-accept'];
        $game->GamePlayers()->sync($users_id);
        $this->post(route("game.accept",[$game->id]))->assertStatus(200);
        Event::assertDispatched(MatchReadyToJoin::class);
    }

}
