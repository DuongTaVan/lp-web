<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoxNotificationTransContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('box_notification_trans_contents', function (Blueprint $table) {
            $table->increments('box_notification_trans_content_id');
            $table->string('title', 255);
            $table->text('body');
            $table->tinyInteger('to_type');
            $table->dateTime('scheduled_at');
            $table->tinyInteger('is_delivered');
            $table->dateTime('delivered_at')->nullable();
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
        Schema::dropIfExists('box_notification_trans_contents');
    }
}
