<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTeacherProfitToCashTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cashes', function (Blueprint $table) {
            $table->decimal('teacher_profit', 15, 0)->after('balance');
//            $table->decimal('profit_before_transfer', 15, 0)->after('teacher_profit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cashes', function (Blueprint $table) {
            $table->dropColumn('teacher_profit');
//            $table->dropColumn('profit_before_transfer');
        });
    }
}
