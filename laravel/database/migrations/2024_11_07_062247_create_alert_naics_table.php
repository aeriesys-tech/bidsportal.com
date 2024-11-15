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
        Schema::create('alert_naics', function (Blueprint $table) {
            $table->id('alert_naics_id');
            $table->foreignId('alert_id')->onDelete('cascade')->index();
            $table->foreign('alert_id')->references('alert_id')->on('alerts');
            $table->foreignId('naics_id')->onDelete('cascade')->index();
            $table->foreign('naics_id')->references('naics_id')->on('naics');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alert_naics');
    }
};
