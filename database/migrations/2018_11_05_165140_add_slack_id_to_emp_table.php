<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlackIdToEmpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function($table) {
            $table->string('slack_id')->nullable()->after('id');
        });
    }   

    /**
     * Reverse the migrations.
     *
     * @return void
    */
    
    public function down()
    {
        Schema::table('employees', function($table) {
            $table->dropColumn('slack_id');
        });
    }
}
