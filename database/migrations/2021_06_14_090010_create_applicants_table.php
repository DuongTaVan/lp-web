<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->increments('applicant_id');
            $table->integer('user_id');
            $table->integer('course_schedule_id');
            $table->integer('is_lappi_new');
            $table->integer('is_lappi_repeater');
            $table->integer('lappi_repeat_count');
            $table->integer('is_teacher_new');
            $table->integer('is_teacher_repeater');
            $table->integer('teacher_repeat_count');
            $table->dateTime('canceled_at')->nullable();
            $table->tinyInteger('is_reviewed');
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
        Schema::dropIfExists('applicants');
    }
}
