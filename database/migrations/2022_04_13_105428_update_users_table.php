<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('str_connect_id', 255)->nullable()->after('str_customer_id');
            $table->string('str_person_id', 255)->nullable()->after('str_connect_id');
            $table->boolean('str_verification_session')->default(false)->after('str_person_id');
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
            $table->dropColumn('str_connect_id');
            $table->dropColumn('str_person_id');
            $table->dropColumn('str_verification_session');
        });
    }
}
