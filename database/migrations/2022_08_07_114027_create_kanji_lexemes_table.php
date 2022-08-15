<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKanjiLexemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kanji_lexemes', function (Blueprint $table) {
            $table->id();
            // Note: 'kanji' needs to get passed because the table name does
            // not match Laravel's naming conventions
            $table->foreignId('kanji_id')->constrained('kanji');
            $table->foreignId('lexeme_id')->constrained();
            $table->unique( array('kanji_id','lexeme_id'), 'kanji_lexeme_unique' );
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
        Schema::dropIfExists('kanji_lexemes');
    }
}
