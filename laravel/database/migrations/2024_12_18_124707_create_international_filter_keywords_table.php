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
        Schema::create('international_filter_keywords', function (Blueprint $table) {
            $table->id('international_filter_keyword_id');
            $table->foreignId('international_filter_id')->onDelete('cascade')->index();
            $table->foreign('international_filter_id')->references('international_filter_id')->on('international_filters');
            $table->string('keyword', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('international_filter_keywords');
    }
};