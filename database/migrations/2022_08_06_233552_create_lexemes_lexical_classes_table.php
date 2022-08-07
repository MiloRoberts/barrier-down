<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLexemesLexicalClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lexemes_lexical_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lexeme_id')->constrained();
            $table->foreignId('lexical_class_id')->constrained();
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
        Schema::dropIfExists('lexemes_lexical_classes');
    }
}
