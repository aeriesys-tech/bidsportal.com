<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFederalFilterNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('federal_filter_notices', function (Blueprint $table) {
            $table->id('federal_filter_notice_id');
            $table->foreignId('federal_filter_id')->onDelete('cascade')->index();
            $table->foreign('federal_filter_id')->references('federal_filter_id')->on('federal_filters');
            $table->foreignId('federal_notice_id')->onDelete('cascade')->index();
            $table->foreign('federal_notice_id')->references('federal_notice_id')->on('federal_notices');
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
        Schema::dropIfExists('federal_filter_notices');
    }
}
