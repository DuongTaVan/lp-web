<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFixNumColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->bigInteger('fixed_num')->change();
        });

        Schema::table('course_schedules', function (Blueprint $table) {
            $table->bigInteger('fixed_num')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->integer('fixed_num')->change();
        });

        Schema::table('course_schedules', function (Blueprint $table) {
            $table->integer('fixed_num')->change();
        });
    }
}
