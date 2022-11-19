<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cash_id');
            $table->tinyInteger('status');
            $table->decimal('withdrawal_amount', 15, 0);
            $table->decimal('transfer_fee', 15, 0);
            $table->decimal('transfer_amount', 15, 0);
            $table->date('scheduled_date');
            $table->dateTime('transferred_at')->nullable();
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
        Schema::dropIfExists('transfer_histories');
    }
}
