<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFederalFilterNaicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('federal_filter_naics', function (Blueprint $table) {
            $table->id('federal_filter_naics_id');
            $table->foreignId('federal_filter_id')->onDelete('cascade')->index();
            $table->foreign('federal_filter_id')->references('federal_filter_id')->on('federal_filters');
            $table->foreignId('naics_id')->onDelete('cascade')->index();
            $table->foreign('naics_id')->references('naics_id')->on('naics');
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
        Schema::dropIfExists('federal_filter_naics');
    }
}
