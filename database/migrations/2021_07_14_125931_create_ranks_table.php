<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateRanksTable.
 */
class CreateRanksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ranks', function (Blueprint $table): void {
            $table->increments('rank_id');
            $table->smallInteger('rank_level');
            $table->string('badge_name', 20);
            $table->integer('num_of_courses_held_standard');
            $table->decimal('avg_rating_standard', 3, 2);
            $table->smallInteger('period_days_standard');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('ranks');
    }
}
