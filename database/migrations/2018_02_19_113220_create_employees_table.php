<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('fname');
            $table->string('lname');
            $table->string('fullname');
            $table->string('email');
            $table->string('contact');
            $table->string('password');
            $table->integer('zuid');
            $table->integer('account_id');
            $table->string('org_email')->unique();     
            $table->string('email')->unique();                 
            $table->string('role');    
            $table->softDeletes();            
            $table->boolean('inviteToZoho');
            $table->boolean('inviteToSlack');
            $table->boolean('inviteToAsana');
            $table->integer('status')->default(0);
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
