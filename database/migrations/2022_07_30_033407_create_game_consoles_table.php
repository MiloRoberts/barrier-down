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
            $table->foreignId('console_name_id')->constrained();
            // NOTE: This is equivalent to ...
            // $table->foreign('console_name_id')->references('id')->on('console_names');
            $table->foreignId('console_manufacturer_id')->constrained();
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
        Schema::dropIfExists('game_consoles');
    }
}
