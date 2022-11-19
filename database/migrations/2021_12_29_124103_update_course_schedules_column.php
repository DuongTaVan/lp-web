<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCourseSchedulesColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_schedules', function (Blueprint $table) {
            $table->string('title',255)->change();
            $table->string('subtitle',255)->change();
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
            $table->string('title',255)->change();
            $table->string('subtitle',255)->change();
        });
    }
}
