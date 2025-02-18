<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rounds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('roundNumber');
            $table->string('c_name');
            $table->integer('c_year');
            
        });
        Schema::table('rounds', function (Blueprint $table) {
            $table->foreign('c_name')->references('name')->on('competitions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('c_year')->references('year')->on('competitions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rounds', function (Blueprint $table) {
            $table->dropForeign(['c_name']);
            $table->dropColumn('c_name');
            $table->dropForeign(['c_year']);
            $table->dropColumn('c_year');
        });
        Schema::dropIfExists('rounds');
    }
}
