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
            $table->string('contact_no');
            $table->string('emergency_contact_relationship');
            $table->string('emergency_contact');            
            $table->string('password');
            $table->integer('zuid')->default(0);
            $table->integer('account_id')->default(0);  
            $table->string('official_email')->unique();                 
            $table->string('personal_email')->unique();     
            $table->string('role');    
            $table->string('type')->comment('work from remote/office')->default('office');    
            $table->integer('status')->default(1);
            $table->boolean('invite_to_zoho');
            $table->boolean('invite_to_slack');
            $table->boolean('invite_to_asana');
            $table->string('cnic');
            $table->date('date_of_birth');
            $table->string('current_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('city');
            $table->string('office_location_id')->default(0);
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
