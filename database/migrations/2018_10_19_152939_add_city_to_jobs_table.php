<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCityToJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function($table)
        {
            $table->dropColumn('featured');
            $table->dropColumn('category_id');
            $table->string('city')->nullable()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function($table)
        {
            $table->dropColumn('city');
            $table->string('featured')->nullable()->after('description');
            $table->string('category_id')->nullable()->after('description');
        });
    }
}
