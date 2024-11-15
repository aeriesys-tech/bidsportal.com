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
        Schema::create('state_filter_notices', function (Blueprint $table) {
            $table->id('state_filter_notice_id');
            $table->foreignId('state_filter_id')->onDelete('cascade')->index();
            $table->foreign('state_filter_id')->references('state_filter_id')->on('state_filters');
            $table->foreignId('state_notice_id')->onDelete('cascade')->index();
            $table->foreign('state_notice_id')->references('state_notice_id')->on('state_notices');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('state_filter_notices');
    }
};
