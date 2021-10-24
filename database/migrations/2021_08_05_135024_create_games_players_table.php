<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesPlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games_players', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("game_id");
            $table->json("cards")->nullable();
            $table->json("in_use_cards")->nullable();
            $table->enum("status",["ready","waiting-for-accept","turn"])->nullable();
            $table->foreign("user_id")
                ->references("id")
                ->on("users");
            $table->foreign("game_id")
                ->references("id")
                ->on("games");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games_players');
    }
}
