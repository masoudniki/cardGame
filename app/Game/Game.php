<?php

namespace App\Game;

use App\Card\CardDistributor;
use App\Events\MatchWasFound;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Game
{
    public $players;
    public $cardDistributor;
    public $game;
    public function __construct($players,CardDistributor $cardDistributor){
        $this->cardDistributor=$cardDistributor;
        $this->players=$players;
    }
    public function createGame(){
        $this->assignGameToPlayers(
            $this->addGameRecord(),
            $this->players,
            $this->cardDistributor
                ->shuffle(3)
                ->distribute()
        );
        $this->awarePlayersMatchWasFounded();
    }
    private function addGameRecord(){
        $this->game= \App\Models\Game::query()->create([
            "status"=>"waiting-for-players-to-accept"
        ]);
        return $this->game;
    }
    private function assignGameToPlayers($game,Collection $players,$playerCards): void
    {
        $data=[];
        foreach ($players as $player){
            $cards=json_encode(array_pop($playerCards));
            $data[]=  ["game_id" => $game->id, "user_id" => $player->id, "cards" =>$cards ,"in_use_cards"=>$cards,"status"=>"waiting-for-accept"];
        }
        DB::table("games_players")
            ->insert($data);
    }
    public function awarePlayersMatchWasFounded(){
        MatchWasFound::dispatch($this->game,$this->players);
    }
}
