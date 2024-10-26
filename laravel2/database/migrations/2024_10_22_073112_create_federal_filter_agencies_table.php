<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFederalFilterAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('federal_filter_agencies', function (Blueprint $table) {
            $table->id('federal_filter_agency_id');
            $table->foreignId('federal_filter_id')->onDelete('cascade')->index();
            $table->foreign('federal_filter_id')->references('federal_filter_id')->on('federal_filters');
            $table->foreignId('federal_agency_id')->onDelete('cascade')->index();
            $table->foreign('federal_agency_id')->references('federal_agency_id')->on('federal_agencies');
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
        Schema::dropIfExists('federal_filter_federal_agencies');
    }
}
