<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_id');
            $table->string('item', 10);
            $table->integer('course_schedule_id')->nullable();
            $table->integer('optional_extra_id')->nullable();
            $table->integer('question_ticket_id')->nullable();
            $table->integer('gift_id')->nullable();
            $table->decimal('unit_price', 15, 0);
            $table->integer('quantity');
            $table->decimal('total_amount', 15, 0);
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
        Schema::dropIfExists('purchase_details');
    }
}
