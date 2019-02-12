<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->string('status')->default('preparing');
        });
        Schema::table('debates', function (Blueprint $table) {
            $table->string('status')->default('preparing');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user');
        });
        Schema::table('tags', function (Blueprint $table) {
            $table->integer('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('debates', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
