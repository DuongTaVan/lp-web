<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BankAccountHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_account_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('old_id');
            $table->integer('user_id');
            $table->string('bank_name', 255);
            $table->string('branch_name', 255);
            $table->tinyInteger('account_type');
            $table->string('account_number', 7);
            $table->string('account_name', 255);
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
        Schema::dropIfExists('bank_account_histories');
    }
}
