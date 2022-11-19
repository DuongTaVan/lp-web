<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_masters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('code')->index()->nullable();
            $table->string('name')->index()->nullable();
            $table->string('name_kana')->index()->nullable();
            $table->integer('parent_id')->index()->nullable()->comment('NULL:bank');
            $table->integer('type')->index()->nullable()->comment('0:bank, 1:branch');
            $table->string('code_number')->index()->nullable();
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
        Schema::dropIfExists('bank_masters');
    }
}
