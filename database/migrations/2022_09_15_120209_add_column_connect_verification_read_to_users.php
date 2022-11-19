<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnConnectVerificationReadToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('str_verification_session', 'connect_verification_session');
            $table->boolean('connect_verification_read')->default(false)->after('str_verification_session');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('connect_verification_session', 'str_verification_session');
            $table->dropColumn('connect_verification_read');
        });
    }
}
