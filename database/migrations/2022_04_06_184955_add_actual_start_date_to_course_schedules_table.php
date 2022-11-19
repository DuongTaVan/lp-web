<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActualStartDateToCourseSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_schedules', function (Blueprint $table) {
            $table->dateTime('actual_start_date')->nullable()->after('time_sub_course_schedule');
            $table->dateTime('actual_end_date')->nullable()->after('actual_start_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_schedules', function (Blueprint $table) {
            $table->dropColumn('actual_start_date');
            $table->dropColumn('actual_end_date');
        });
    }
}
