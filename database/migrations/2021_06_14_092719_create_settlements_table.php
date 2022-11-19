<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_id');
            $table->char('str_payment_id', 255);
            $table->string('currency', 3);
            $table->tinyInteger('payment_method');
            $table->string('card_brand', 20)->nullable();
            $table->decimal('payment_amount', 15, 0);
            $table->tinyInteger('status');
            $table->dateTime('approval_failed_at')->nullable();
            $table->string('approval_error_reason', 255)->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->decimal('approved_amount', 15, 0)->nullable();
            $table->dateTime('capture_failed_at')->nullable();
            $table->string('capture_error_reason', 255)->nullable();
            $table->dateTime('captured_at')->nullable();
            $table->decimal('captured_amount', 15, 0)->nullable();
            $table->dateTime('cancellation_failed_at')->nullable();
            $table->string('cancellation_error_reason', 255)->nullable();
            $table->dateTime('canceled_at')->nullable();
            $table->decimal('canceled_amount', 15, 0)->nullable();
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
        Schema::dropIfExists('settlements');
    }
}
