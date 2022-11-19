<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStrPayoutIdToTransferHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transfer_histories', function (Blueprint $table) {
            $table->string('str_payout_id', 255)->nullable()->after('scheduled_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transfer_histories', function (Blueprint $table) {
            $table->dropColumn('str_payout_id');
        });
    }
}
