<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->date('target_date');
            $table->date('365_days_ago');
            $table->decimal('total_sales', 15, 0);
            $table->decimal('total_sales_ly', 15, 0)->nullable();
            $table->decimal('course_sales', 15, 0);
            $table->decimal('course_sales_ly', 15, 0)->nullable();
            $table->decimal('extension_sales', 15, 0);
            $table->decimal('extension_sales_ly', 15, 0)->nullable();
            $table->decimal('option_sales', 15, 0);
            $table->decimal('option_sales_ly', 15, 0)->nullable();
            $table->decimal('question_sales', 15, 0);
            $table->decimal('question_sales_ly', 15, 0)->nullable();
            $table->decimal('gift_sales', 15, 0);
            $table->decimal('gift_sales_ly', 15, 0)->nullable();
            $table->decimal('sales_commissions', 15, 0);
            $table->decimal('sales_commissions_ly', 15, 0)->nullable();
            $table->decimal('system_commissions', 15, 0);
            $table->decimal('system_commissions_ly', 15, 0)->nullable();
            $table->decimal('num_of_applicants', 15, 0);
            $table->decimal('num_of_applicants_ly', 15, 0)->nullable();
            $table->decimal('num_of_courses', 15, 0);
            $table->decimal('num_of_courses_ly', 15, 0)->nullable();
            $table->decimal('streaming_minutes', 15, 0);
            $table->decimal('streaming_minutes_ly', 15, 0)->nullable();
            $table->decimal('teacher_profit_exc_tax', 15, 0);
            $table->decimal('teacher_profit_exc_tax_ly', 15, 0)->nullable();
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
        Schema::dropIfExists('statistics');
    }
}
