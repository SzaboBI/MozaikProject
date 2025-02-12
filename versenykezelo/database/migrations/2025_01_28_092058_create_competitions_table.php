<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitions', function (Blueprint $table) {
            $table->timestamps();
            $table->string('name')->nullable(false);
            $table->integer('year')->nullable(false);
            $table->integer('pointsForGoodAnswer');
            $table->integer('pointsForBadAnswer');
            $table->integer('poinstForEmptyAnswer');
            $table->primary(array('name','year'));
            
        });
        Schema::table('competitions', function (Blueprint $table) {
            $table->index('name');
            $table->index('year');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('competitions', function (Blueprint $table) {
            $table->dropIndex('name');
            $table->dropIndex('year');
        });*/
        Schema::dropIfExists('competitions');
    }
}
