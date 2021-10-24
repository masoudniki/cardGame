<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_rounds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("game_id");
            $table->unsignedBigInteger("boss_id");
            $table->unsignedBigInteger("winner_team");
            $table->foreign("game_id")
                ->references("id")
                ->on("games");
            $table->foreign("winner_team")
                ->references("id")
                ->on("teams");
            $table->foreign("boss_id")
                ->references("id")
                ->on("users");
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
        Schema::dropIfExists('game_rounds');
    }
}
