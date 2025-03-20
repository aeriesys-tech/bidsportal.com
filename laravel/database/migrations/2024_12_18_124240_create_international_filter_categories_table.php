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
        Schema::create('international_filter_categories', function (Blueprint $table) {
            $table->id('international_filter_agency_id');
            $table->foreignId('international_filter_id')->onDelete('cascade')->index();
            $table->foreign('international_filter_id')->references('international_filter_id')->on('international_filters');
            $table->foreignId('international_agency_id')->onDelete('cascade')->index();
            $table->foreign('international_agency_id')->references('international_agency_id')->on('international_agencies');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('international_filter_categories');
    }
};
