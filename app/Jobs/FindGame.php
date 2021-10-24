<?php

namespace App\Jobs;

use App\Card\CardDistributor;
use App\Game\Game;
use App\Models\SearchingUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FindGame implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->queue="game-finder";
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->isThereEnoughPlayerToCreateGame()){
            $players=$this->pop4LastPlayerWantToPlay();
            $game=new Game($players,new CardDistributor());
            $game->createGame();
        }
    }
    public function pop4LastPlayerWantToPlay(){
        $players=SearchingUser::query()->orderBy("created_at","asc")->limit(4)->get();
        SearchingUser::query()->whereIn("user_id",$players->map(function ($item){return $item->id;})->toArray())->delete();
        return $players;
    }
    public function isThereEnoughPlayerToCreateGame(): bool
    {
        return SearchingUser::query()->count("*")>=4;
    }

}
