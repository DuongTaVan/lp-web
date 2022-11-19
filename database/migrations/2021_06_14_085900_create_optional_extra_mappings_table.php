<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionalExtraMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('optional_extra_mappings', function (Blueprint $table) {
            $table->integer('course_schedule_id');
            $table->integer('optional_extra_id');
            $table->unique(['course_schedule_id', 'optional_extra_id'], 'optional_extra_mapping_unique');
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
        Schema::dropIfExists('optional_extra_mappings');
    }
}
