<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('purchase_id');
            $table->char('order_no', 14);
            $table->integer('user_id');
            $table->integer('course_schedule_id');
            $table->tinyInteger('status');
            $table->decimal('subtotal_amount', 15, 0);
            $table->decimal('discount_amount', 15, 0);
            $table->decimal('total_amount', 15, 0);
            $table->dateTime('purchased_at');
            $table->dateTime('canceled_at')->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
