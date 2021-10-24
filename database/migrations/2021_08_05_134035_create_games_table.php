<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->enum("status",["finished","freeze","running","determining-hokm","determining-hakem","waiting-for-players-to-accept","waiting-for-players-to-join"]);
            $table->string("hokm")->nullable();
            $table->unsignedBigInteger("hakem")->nullable();
            $table
                ->foreign("hakem")
                ->references("id")
                ->on("users");;
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
        Schema::dropIfExists('games');
    }
}
