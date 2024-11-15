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
        Schema::create('alert_set_asides', function (Blueprint $table) {
            $table->id('alert_set_aside_id');
            $table->foreignId('alert_id')->onDelete('cascade')->index();
            $table->foreign('alert_id')->references('alert_id')->on('alerts');
            $table->foreignId('set_aside_id')->onDelete('cascade')->index();
            $table->foreign('set_aside_id')->references('set_aside_id')->on('set_asides');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alert_set_asides');
    }
};
