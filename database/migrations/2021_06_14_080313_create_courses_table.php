<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('course_id');
            $table->integer('user_id');
            $table->tinyInteger('type');
            $table->integer('parent_course_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('title', 255)->nullable();
            $table->string('subtitle', 255)->nullable();
            $table->text('body')->nullable();
            $table->text('flow')->nullable();
            $table->text('cautions')->nullable();
            $table->smallInteger('minutes_required');
            $table->decimal('price', 15, 0);
            $table->integer('fixed_num');
            $table->tinyInteger('dist_method');
            $table->double('rating', 3, 0);
            $table->integer('num_of_ratings');
            $table->tinyInteger('approval_status')->default(0);
            $table->tinyInteger('is_archived');
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
        Schema::dropIfExists('courses');
    }
}
