<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailNotificationTransContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_notification_trans_contents', function (Blueprint $table) {
            $table->increments('email_notification_trans_content_id');
            $table->string('title', 255);
            $table->text('body');
            $table->text('to_user_ids')->nullable();
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
        Schema::dropIfExists('email_notification_trans_contents');
    }
}
