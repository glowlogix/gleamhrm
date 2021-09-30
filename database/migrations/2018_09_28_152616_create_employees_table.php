<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('contact_no');
            $table->string('official_email')->unique();
            $table->string('personal_email')->unique();
            $table->string('identity_no')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('emergency_contact_relationship')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->text('emergency_contact_address')->nullable();
            $table->string('password');
            $table->text('current_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('city')->nullable();
            $table->string('designation')->nullable();
            $table->string('type')->comment('work from remote/office')->default('office');
            $table->integer('status')->default(1);
            $table->string('employment_status')->nullable();
            $table->string('picture')->nullable();
            $table->date('joining_date')->nullable();
            $table->date('exit_date')->nullable();
            $table->integer('gross_salary')->nullable()->default(0);
            $table->integer('bonus')->nullable()->default(0);
            $table->string('branch_id')->default(0);
            $table->string('department_id')->nullable();
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('employees');
    }
}
