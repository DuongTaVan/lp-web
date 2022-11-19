<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsoleUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('console_users', function (Blueprint $table) {
            $table->increments('console_user_id');
            $table->string('email', 254);
            $table->string('password', 255);
            $table->string('remember_token', 255)->nullable();
            $table->tinyInteger('is_archived');
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
        Schema::dropIfExists('console_users');
    }
}
