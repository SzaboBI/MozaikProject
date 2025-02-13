<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('postcode');
            $table->string('city');
            $table->string('road');
            $table->integer('houseNumber');
            $table->string('telephone');
            $table->rememberToken();
            $table->timestamps();
            $table->primary('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
    }
}
