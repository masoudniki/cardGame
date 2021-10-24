<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoundDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('round_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("game_round_id");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("card");
            $table->timestamps();
            $table->foreign("game_round_id")
                ->references("id")
                ->on("game_rounds");
            $table->foreign("user_id")
                ->references("id")
                ->on("users");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('round_details');
    }
}
