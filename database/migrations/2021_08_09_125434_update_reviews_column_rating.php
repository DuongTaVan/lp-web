<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateReviewsColumnRating extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws \Doctrine\DBAL\Exception
     */
    public function up()
    {
        DB::statement('ALTER TABLE `reviews` MODIFY `rating` DOUBLE(3,2)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `reviews` MODIFY `rating` DOUBLE(3,0)');
    }
}
