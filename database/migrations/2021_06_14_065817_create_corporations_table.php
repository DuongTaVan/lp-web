<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorporationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporations', function (Blueprint $table) {
            $table->increments('corporation_id');
            $table->string('name', 255);
            $table->string('name_kana', 255);
            $table->string('address', 255);
            $table->date('establishment_date');
            $table->string('last_name_kanji', 255);
            $table->string('first_name_kanji', 255);
            $table->string('last_name_kana', 255);
            $table->string('first_name_kana', 255);
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
        Schema::dropIfExists('corporations');
    }
}
