<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFirstTimestampInAndLastTimestampOutToAttendanceSummaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendance_summaries', function($table) {
            $table->dateTime('first_timestamp_in')->nullable()->after('last_time_out');
            $table->dateTime('last_timestamp_out')->nullable()->after('first_timestamp_in');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendances', function($table) {
            $table->dropColumn('first_timestamp_in');
            $table->dropColumn('last_timestamp_out');
        });
    }
}

