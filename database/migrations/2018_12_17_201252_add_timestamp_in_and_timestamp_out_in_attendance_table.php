<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddTimestampInAndTimestampOutInAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendances', function ($table) {
            $table->dateTime('timestamp_in')->nullable()->after('time_out');
            $table->dateTime('timestamp_out')->nullable()->after('timestamp_in');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendances', function ($table) {
            $table->dropColumn('timestamp_in');
            $table->dropColumn('timestamp_out');
        });
    }
}
