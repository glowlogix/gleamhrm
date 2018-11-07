<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applicants', function($table) {
            $table->dropColumn('job_id');
        });
        Schema::table('applicants', function($table) {
            $table->unsignedInteger('job_id')->after('recruited');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('applicants', function($table) {
            $table->dropColumn('job_id');
        });
        Schema::table('applicants', function($table) {
            $table->integer('job_id')->after('recruited');
        });
    }
}
