<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceBreaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_breaks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->dateTime('timestamp_break_start');
            $table->dateTime('timestamp_break_end')->nullable();
            $table->date('date');
            $table->string('comment')->nullable();
            $table->string('status')->default('present');
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
        Schema::dropIfExists('attendance_breaks');
    }
}
