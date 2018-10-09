<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leaves', function($table)
        {
            // $table->string('status')->nullable()->change(); set this line
            $table->string('cc_to')->nullable()->after('status');
            $table->integer('point_of_contact')->default(0)->after('status');
            $table->longText('description')->nullable()->after('status');
            $table->string('line_manager')->nullable()->after('status');
            $table->string('subject')->nullable()->after('status');
            // $table->dropColumn('reason');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
