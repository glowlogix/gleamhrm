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
            $table->string('firstname');
            $table->string('lastname');
            $table->string('fullname');
            $table->string('contact');
            $table->string('emergency_contact');            
            $table->string('emergency_contact_relationship');
            $table->string('password');
            $table->integer('zuid');
            $table->integer('account_id');
            $table->string('org_email')->unique();     
            $table->string('email')->unique();                 
            $table->string('role');    
            $table->boolean('inviteToZoho');
            $table->boolean('inviteToSlack');
            $table->boolean('inviteToAsana');
            $table->integer('status')->default(1);
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
