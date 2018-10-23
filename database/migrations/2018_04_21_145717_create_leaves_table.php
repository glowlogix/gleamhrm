<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->string('leave_type');
            $table->dateTime('datefrom')->nullable();
            $table->dateTime('dateto')->nullable();
            $table->string('cc_to')->nullable();
            $table->integer('point_of_contact')->default(0);
            $table->longText('description')->nullable();
            $table->string('line_manager')->nullable();
            $table->string('subject')->nullable();
            $table->string('status');                        
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
        Schema::dropIfExists('leaves');
    }
}
