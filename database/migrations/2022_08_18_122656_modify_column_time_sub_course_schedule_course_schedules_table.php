<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnTimeSubCourseScheduleCourseSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_schedules', function (Blueprint $table) {
            $table->dropColumn('time_sub_course_schedule');
            $table->string('group', 255)->nullable()->after('canceled_at');
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
            $table->dropColumn('group');
            $table->dateTime('time_sub_course_schedule')->nullable()->after('canceled_at');
        });
    }
}
