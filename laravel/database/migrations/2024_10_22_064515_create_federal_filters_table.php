<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFederalFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('federal_filters', function (Blueprint $table) {
            $table->id('federal_filter_id');
            $table->string('federal_filter_name', 50);
            $table->foreignId('user_id')->onDelete('cascade')->index();
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->boolean('active')->nullable();
            $table->boolean('expired')->nullable();
            $table->string('posted_date', 50)->nullable();
            $table->datetime('posted_from_date')->nullable();
            $table->datetime('posted_to_date')->nullable();
            $table->string('response_date', 50)->nullable();
            $table->datetime('response_from_date')->nullable();
            $table->datetime('response_to_date')->nullable();
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
        Schema::dropIfExists('federal_filters');
    }
}