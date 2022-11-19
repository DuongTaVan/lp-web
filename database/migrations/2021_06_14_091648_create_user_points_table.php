<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_points', function (Blueprint $table) {
            $table->increments('user_point_id');
            $table->integer('user_id');
            $table->decimal('deposit_points', 15, 0)->nullable();
            $table->tinyInteger('deposit_reason')->nullable();
            $table->decimal('withdrawal_points', 15, 0)->nullable();
            $table->tinyInteger('withdrawal_reason')->nullable();
            $table->decimal('points_balance', 15, 0);
            $table->dateTime('transacted_at');
            $table->decimal('consumed_points', 15, 0)->nullable();
            $table->tinyInteger('is_consumed')->nullable();
            $table->date('expiration_date')->nullable();
            $table->tinyInteger('is_processed')->nullable();
            $table->integer('expired_user_point_id')->nullable();
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
        Schema::dropIfExists('user_points');
    }
}
