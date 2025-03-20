<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFederalFilterSetAsidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('federal_filter_set_asides', function (Blueprint $table) {
            $table->id('federal_filter_set_aside_id');
            $table->foreignId('federal_filter_id')->onDelete('cascade')->index();
            $table->foreign('federal_filter_id')->references('federal_filter_id')->on('federal_filters');
            $table->foreignId('set_aside_id')->onDelete('cascade')->index();
            $table->foreign('set_aside_id')->references('set_aside_id')->on('set_asides');
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
        Schema::dropIfExists('federal_filter_set_asides');
    }
}
