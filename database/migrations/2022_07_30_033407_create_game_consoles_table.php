<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameConsolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_consoles', function (Blueprint $table) {
            $table->id();
            // NOTE: $table->foreignId('console_name_id')->constrained(); is equivalent to ...
            // $table->foreign('console_name_id')->references('id')->on('console_names');
            $table->string('console')->unique();
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
        Schema::dropIfExists('game_consoles');
    }
}
