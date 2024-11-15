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
        Schema::create('state_filter_agencies', function (Blueprint $table) {
            $table->id('state_filter_agency_id');
            $table->foreignId('state_filter_id')->onDelete('cascade')->index();
            $table->foreign('state_filter_id')->references('state_filter_id')->on('state_filters');
            $table->foreignId('state_agency_id')->onDelete('cascade')->index();
            $table->foreign('state_agency_id')->references('state_agency_id')->on('state_agencies');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('state_filter_agencies');
    }
};
