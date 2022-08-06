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
            // $table->foreignId('game_console_id');
            $table->foreignId('game_console_id')->constrained();
            // $table->foreign('game_console_id')->references('id')->on('game_consoles');
            $table->foreignId('game_title_id')->constrained();
            // should this stay as nullable?
            $table->text('info')->nullable();
            // maybe get a slug from a method instead
            $table->string('slug')->unique();
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
