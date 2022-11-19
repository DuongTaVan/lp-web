<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_schedules', function (Blueprint $table) {
            $table->increments('course_schedule_id');
            $table->integer('course_id');
            $table->tinyInteger('type');
            $table->integer('parent_course_schedule_id')->nullable();
            $table->tinyInteger('status');
            $table->string('title', 255)->nullable();
            $table->string('subtitle', 30)->nullable();
            $table->string('body', 1000)->nullable();
            $table->string('flow', 1000)->nullable();
            $table->string('cautions', 1000)->nullable();
            $table->integer('minutes_required');
            $table->decimal('price', 15, 0);
            $table->integer('fixed_num');
            $table->integer('num_of_applicants');
            $table->dateTime('purchase_deadline');
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->char('agora_channel', 32)->nullable();
            $table->string('agora_token', 255)->nullable();
            $table->dateTime('canceled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_schedules');
    }
}
