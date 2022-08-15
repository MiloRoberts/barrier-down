<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLexemesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lexemes_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lexeme_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->unique( array('lexeme_id','user_id'), 'lexeme_user_unique' );
            $table->boolean('learning')->default(false);;
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
        Schema::dropIfExists('lexemes_users');
    }
}
