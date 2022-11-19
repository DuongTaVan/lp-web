<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashes', function (Blueprint $table) {
            $table->increments('cash_id');
            $table->integer('user_id');
            $table->decimal('deposit_amount', 15, 0)->nullable();
            $table->tinyInteger('deposit_reason')->nullable();
            $table->decimal('withdrawal_amount', 15, 0)->nullable();
            $table->tinyInteger('withdrawal_reason')->nullable();
            $table->decimal('balance', 15, 0);
            $table->dateTime('transacted_at');
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
        Schema::dropIfExists('cashes');
    }
}
