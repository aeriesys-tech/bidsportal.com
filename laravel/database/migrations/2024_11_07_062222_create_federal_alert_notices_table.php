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
        Schema::create('federal_alert_notices', function (Blueprint $table) {
            $table->id('federal_alert_notice_id');
            $table->foreignId('alert_id')->onDelete('cascade')->index();
            $table->foreign('alert_id')->references('alert_id')->on('alerts');
            $table->foreignId('federal_notice_id')->onDelete('cascade')->index();
            $table->foreign('federal_notice_id')->references('federal_notice_id')->on('federal_notices');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('federal_alert_notices');
    }
};
