<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFederalFilterStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('federal_filter_states', function (Blueprint $table) {
            $table->id('federal_filter_state_id');
            $table->foreignId('federal_filter_id')->onDelete('cascade')->index();
            $table->foreign('federal_filter_id')->references('federal_filter_id')->on('federal_filters');
            $table->foreignId('state_id')->onDelete('cascade')->index();
            $table->foreign('state_id')->references('state_id')->on('states');
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
        Schema::dropIfExists('federal_filter_states');
    }
}
