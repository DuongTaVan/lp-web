<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnReasonFailToTransferHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transfer_histories', function (Blueprint $table) {
            $table->dropColumn('reason_fail');
            $table->string('failure_code')->nullable()->after('status');
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
            $table->tinyInteger('reason_fail')->nullable()->after('status');
            $table->dropColumn('failure_code');
        });
    }
}
