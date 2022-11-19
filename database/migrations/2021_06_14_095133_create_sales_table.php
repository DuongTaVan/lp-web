<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('course_schedule_id');
            $table->date('target_date');
            $table->integer('cash_id');
            $table->integer('is_skills')->default(0);
            $table->integer('is_skills_sub')->default(0);
            $table->integer('is_consultation')->default(0);
            $table->integer('is_fortunetelling')->default(0);
            $table->bigInteger('total_minutes')->default(0);
            $table->bigInteger('minutes_skills')->default(0);
            $table->bigInteger('minutes_skills_sub')->default(0);
            $table->bigInteger('minutes_skills_sub_extended')->default(0);
            $table->integer('skills_sub_extension_count')->default(0);
            $table->bigInteger('minutes_consultation')->default(0);
            $table->bigInteger('minutes_consultation_extended')->default(0);
            $table->integer('consultation_extension_count')->default(0);
            $table->bigInteger('minutes_fortunetelling')->default(0);
            $table->bigInteger('minutes_fortunetelling_extended')->default(0);
            $table->integer('fortunetelling_extension_count')->default(0);
            $table->integer('total_applicants')->default(0);
            $table->integer('total_applicants_lappi_new')->default(0);
            $table->integer('total_applicants_lappi_repeater')->default(0);
            $table->integer('skills_applicants')->default(0);
            $table->integer('skills_applicants_teacher_new')->default(0);
            $table->integer('skills_applicants_teacher_repeater')->default(0);
            $table->integer('skills_sub_applicants')->default(0);
            $table->integer('skills_sub_applicants_teacher_new')->default(0);
            $table->integer('skills_sub_applicants_teacher_repeater')->default(0);
            $table->integer('consultation_applicants')->default(0);
            $table->integer('consultation_applicants_teacher_new')->default(0);
            $table->integer('consultation_applicants_teacher_repeater')->default(0);
            $table->integer('fortunetelling_applicants')->default(0);
            $table->integer('fortunetelling_applicants_teacher_new')->default(0);
            $table->integer('fortunetelling_applicants_teacher_repeater')->default(0);
            $table->decimal('base_price', 15, 0)->default(0);
            $table->decimal('course_sales', 15, 0)->default(0);
            $table->decimal('extension_sales', 15, 0)->default(0);
            $table->integer('extension_count')->default(0);
            $table->decimal('option_sales', 15, 0)->default(0);
            $table->integer('option_count')->default(0);
            $table->decimal('question_sales', 15, 0)->default(0);
            $table->integer('question_count')->default(0);
            $table->decimal('gift_sales', 15, 0)->default(0);
            $table->integer('gift_count')->default(0);
            $table->decimal('total_sales_skills', 15, 0)->default(0);
            $table->decimal('total_sales_skills_sub', 15, 0)->default(0);
            $table->decimal('total_sales_consultation', 15, 0)->default(0);
            $table->decimal('total_sales_fortunetelling', 15, 0)->default(0);
            $table->decimal('total_sales', 15, 0)->default(0);
            $table->decimal('sales_commissions', 15, 0)->default(0);
            $table->decimal('system_commissions', 15, 0)->default(0);
            $table->decimal('total_commissions', 15, 0)->default(0);
            $table->decimal('teacher_profit', 15, 0)->default(0);
            $table->decimal('tax_rate', 3, 1)->default(0);
            $table->decimal('tax_amount', 15, 0)->default(0);
            $table->decimal('teacher_profit_exc_tax', 15, 0)->default(0);
            $table->decimal('sales_skills_genre_1', 15, 0)->default(0);
            $table->decimal('sales_skills_genre_2', 15, 0)->default(0);
            $table->decimal('sales_skills_genre_3', 15, 0)->default(0);
            $table->decimal('sales_skills_genre_4', 15, 0)->default(0);
            $table->decimal('sales_skills_genre_5', 15, 0)->default(0);
            $table->decimal('sales_skills_genre_6', 15, 0)->default(0);
            $table->decimal('sales_skills_genre_7', 15, 0)->default(0);
            $table->decimal('sales_skills_genre_8', 15, 0)->default(0);
            $table->decimal('sales_skills_genre_9', 15, 0)->default(0);
            $table->decimal('sales_skills_genre_10', 15, 0)->default(0);
            $table->decimal('sales_skills_genre_11', 15, 0)->default(0);
            $table->decimal('sales_skills_genre_12', 15, 0)->default(0);
            $table->decimal('sales_skills_genre_13', 15, 0)->default(0);
            $table->decimal('sales_consultation_genre_1', 15, 0)->default(0);
            $table->decimal('sales_consultation_genre_2', 15, 0)->default(0);
            $table->decimal('sales_consultation_genre_3', 15, 0)->default(0);
            $table->decimal('sales_consultation_genre_4', 15, 0)->default(0);
            $table->decimal('sales_consultation_genre_5', 15, 0)->default(0);
            $table->decimal('sales_consultation_genre_6', 15, 0)->default(0);
            $table->decimal('sales_consultation_genre_7', 15, 0)->default(0);
            $table->decimal('sales_consultation_genre_8', 15, 0)->default(0);
            $table->decimal('sales_consultation_genre_9', 15, 0)->default(0);
            $table->decimal('sales_fortunetelling_genre_1', 15, 0)->default(0);
            $table->decimal('sales_fortunetelling_genre_2', 15, 0)->default(0);
            $table->decimal('sales_fortunetelling_genre_3', 15, 0)->default(0);
            $table->decimal('sales_fortunetelling_genre_4', 15, 0)->default(0);
            $table->decimal('sales_fortunetelling_genre_5', 15, 0)->default(0);
            $table->decimal('sales_fortunetelling_genre_6', 15, 0)->default(0);
            $table->decimal('sales_fortunetelling_genre_7', 15, 0)->default(0);
            $table->decimal('sales_fortunetelling_genre_8', 15, 0)->default(0);
            $table->decimal('sales_fortunetelling_genre_9', 15, 0)->default(0);
            $table->decimal('sales_fortunetelling_genre_10', 15, 0)->default(0);
            $table->decimal('sales_fortunetelling_genre_11', 15, 0)->default(0);
            $table->decimal('sales_male', 15, 0)->default(0);
            $table->decimal('sales_female', 15, 0)->default(0);
            $table->decimal('sales_unapplicable', 15, 0)->default(0);
            $table->decimal('sales_10s', 15, 0)->default(0);
            $table->decimal('sales_20s', 15, 0)->default(0);
            $table->decimal('sales_30s', 15, 0)->default(0);
            $table->decimal('sales_40s', 15, 0)->default(0);
            $table->decimal('sales_50s', 15, 0)->default(0);
            $table->decimal('sales_60s', 15, 0)->default(0);
            $table->tinyInteger('is_imported')->default(0);
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
        Schema::dropIfExists('sales');
    }
}
