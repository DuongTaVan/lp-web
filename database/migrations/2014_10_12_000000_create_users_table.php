<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            $table->tinyInteger('user_type');
            $table->tinyInteger('teacher_type')->nullable();
            $table->tinyInteger('teacher_category_skills')->nullable();
            $table->tinyInteger('teacher_category_consultation')->nullable();
            $table->tinyInteger('teacher_category_fortunetelling')->nullable();
            $table->integer('corporation_id')->nullable();
            $table->string('login_type', 45);
            $table->string('email', 254);
            $table->string('password', 191)->nullable();
            $table->rememberToken();
            $table->string('line_id', 191)->nullable();
            $table->string('facebook_id', 191)->nullable();
            $table->string('google_id', 191)->nullable();
            $table->string('nickname', 255);
            $table->string('last_name_kanji', 255)->nullable();
            $table->string('first_name_kanji', 255)->nullable();
            $table->string('last_name_kana', 255)->nullable();
            $table->string('first_name_kana', 255)->nullable();
            $table->date('date_of_birth');
            $table->tinyInteger('sex');
            $table->string('profile_image', 255)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('business_name', 255)->nullable();
            $table->string('business_name_kana', 255)->nullable();
            $table->mediumText('catchphrase')->nullable();
            $table->text('biography')->nullable();
            $table->string('str_customer_id', 255)->nullable();
            $table->decimal('cash_balance', 15, 0);
            $table->decimal('points_balance', 15, 0);
            $table->tinyInteger('identity_verification_status');
            $table->tinyInteger('business_card_verification_status');
            $table->tinyInteger('nda_status');
            $table->dateTime('last_login');
            $table->tinyInteger('registration_status');
            $table->tinyInteger('is_archived');
            $table->smallInteger('archive_reason')->nullable()
                ->comment('1: 使い方がよく分からなかった, 2: 利用したいサービスがなかった, 3: トラブルがあった（出品者・運営者）, 4: トラブルがあった（購入者, 5: 収益が上がらない\n6: その他');
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
        Schema::dropIfExists('users');
    }
}
