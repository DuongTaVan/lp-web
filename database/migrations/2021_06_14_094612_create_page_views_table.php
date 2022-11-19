<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->tinyInteger('view_count');
            $table->tinyInteger('is_top_page');
            $table->tinyInteger('is_skills');
            $table->tinyInteger('is_consultation');
            $table->tinyInteger('is_fortunetelling');
            $table->integer('to_user_id')->nullable();
            $table->integer('to_course_schedule_id')->nullable();
            $table->dateTime('viewed_at');
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
        Schema::dropIfExists('page_views');
    }
}
