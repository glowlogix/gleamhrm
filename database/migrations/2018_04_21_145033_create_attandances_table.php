<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttandancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attandances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->boolean('delay');
            $table->dateTime('checkintime');
            $table->dateTime('checkouttime');
            $table->dateTime('hourslogged');            
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
        Schema::dropIfExists('attandances');
    }
}
