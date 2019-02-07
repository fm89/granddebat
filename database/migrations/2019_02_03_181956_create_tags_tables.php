<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name');
            $table->integer('question_id');
            $table->foreign('question_id')->references('id')->on('questions');
            $table->timestamps();
        });
        Schema::create('actions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tag_id');
            $table->foreign('tag_id')->references('id')->on('tags');
            $table->integer('response_id');
            $table->foreign('response_id')->references('id')->on('responses');
            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('actions');
        Schema::dropIfExists('tags');
    }
}
