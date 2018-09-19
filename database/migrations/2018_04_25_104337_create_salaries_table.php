<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
<<<<<<< HEAD:database/migrations/2018_04_18_144447_uploads.php
            $table->string('filename',255);
            $table->integer('status')->default(1);
=======
            $table->unsignedInteger('employee_id');
            $table->string('basic_salary');
            $table->softDeletes();
            $table->timestamps();
>>>>>>> c20c5e38d3ee97b490800e6067225edba3ee08cc:database/migrations/2018_04_25_104337_create_salaries_table.php
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
