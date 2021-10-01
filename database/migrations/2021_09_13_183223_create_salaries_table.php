<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            // $table->string('filename', 255);
            // $table->integer('status')->default(1);

            $table->string('gross_salary')->nullable();
            $table->string('basic_salary')->nullable();
            $table->string('home_allowance')->nullable();
            $table->string('medical_allowance')->nullable();
            $table->string('special_allowance')->nullable();
            $table->string('meal_allowance')->nullable();
            $table->string('conveyance_allowance')->nullable();
            $table->string('pf_deduction')->nullable();
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
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
        Schema::dropIfExists('salaries');
    }
}
