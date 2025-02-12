<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersenyzoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versenyzoks', function (Blueprint $table) {
            $table->string('u_email');
            $table->bigInteger('r_id')->unsigned();
            $table->timestamps();
        });
        Schema::table('versenyzoks', function (Blueprint $table) {
            $table->foreign('u_email')->references('email')->on('users');
            $table->foreign('r_id')->references('id')->on('rounds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('versenyzoks');
    }
}
