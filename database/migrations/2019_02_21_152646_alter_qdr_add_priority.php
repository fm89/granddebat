<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterQdrAddPriority extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('debates', function (Blueprint $table) {
            $table->integer('priority')->default(0);
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->integer('priority')->default(0);
        });
        Schema::table('responses', function (Blueprint $table) {
            $table->integer('priority')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('debates', function (Blueprint $table) {
            $table->dropColumn('priority');
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('priority');
        });
        Schema::table('responses', function (Blueprint $table) {
            $table->dropColumn('priority');
        });
    }
}
