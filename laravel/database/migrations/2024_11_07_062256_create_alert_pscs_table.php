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
        Schema::create('alert_pscs', function (Blueprint $table) {
            $table->id('alert_psc_id');
            $table->foreignId('alert_id')->onDelete('cascade')->index();
            $table->foreign('alert_id')->references('alert_id')->on('alerts');
            $table->foreignId('psc_id')->onDelete('cascade')->index();
            $table->foreign('psc_id')->references('psc_id')->on('pscs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alert_pscs');
    }
};
