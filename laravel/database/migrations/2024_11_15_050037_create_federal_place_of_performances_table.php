<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('federal_place_of_performances', function (Blueprint $table) {
            $table->bigIncrements('federal_place_of_performance_id');
            $table->foreignId('federal_tender_id')->onDelete('cascade')->index();
            $table->foreign('federal_tender_id')->references('federal_tender_id')->on('federal_tenders');
            $table->string('city_code', 50)->nullable();
            $table->string('city_name', 50)->nullable();
            $table->string('state_code', 50)->nullable();
            $table->string('state_name', 50)->nullable();
            $table->string('country_code', 50)->nullable();
            $table->string('country_name', 50)->nullable();
            $table->string('zip', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('federal_place_of_performances');
    }
};
