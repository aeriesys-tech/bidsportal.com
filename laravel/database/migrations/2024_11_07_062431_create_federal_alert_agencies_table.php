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
        Schema::create('federal_alert_agencies', function (Blueprint $table) {
            $table->id('federal_alert_agency_id');
            $table->foreignId('alert_id')->onDelete('cascade')->index();
            $table->foreign('alert_id')->references('alert_id')->on('alerts');
            $table->foreignId('federal_agency_id')->onDelete('cascade')->index();
            $table->foreign('federal_agency_id')->references('federal_agency_id')->on('federal_agencies');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('federal_alert_agencies');
    }
};
