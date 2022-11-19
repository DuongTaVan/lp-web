<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();
            $table->tinyInteger('message')->default(0)->comment('0: OFF, 1: ON');
            $table->tinyInteger('followed_or_faved')->default(0)->comment('0: OFF, 1: ON');
            $table->tinyInteger('special_offers')->default(0)->comment('0: OFF, 1: ON');
            $table->tinyInteger('maintenance')->default(0)->comment('0: OFF, 1: ON');
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
        Schema::dropIfExists('notification_settings');
    }
}
