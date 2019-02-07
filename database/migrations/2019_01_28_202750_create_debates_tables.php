<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebatesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('text');
            $table->integer('debate_id');
            $table->foreign('debate_id')->references('id')->on('debates');
            $table->boolean('is_free');
        });
        Schema::create('proposals', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('published_at');
            $table->text('title');
            $table->integer('debate_id');
            $table->foreign('debate_id')->references('id')->on('debates');
            $table->string('author_id');
        });
        Schema::create('responses', function (Blueprint $table) {
            $table->increments('id');
            $table->text('value');
            $table->integer('question_id');
            $table->foreign('question_id')->references('id')->on('questions');
            $table->integer('proposal_id');
            $table->foreign('proposal_id')->references('id')->on('proposals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('responses');
        Schema::dropIfExists('proposals');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('debates');
    }
}
