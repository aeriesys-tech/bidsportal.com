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
        Schema::create('state_filter_categories', function (Blueprint $table) {
            $table->id('state_filter_category_id');
            $table->foreignId('state_filter_id')->onDelete('cascade')->index();
            $table->foreign('state_filter_id')->references('state_filter_id')->on('state_filters');
            $table->foreignId('category_id')->onDelete('cascade')->index();
            $table->foreign('category_id')->references('category_id')->on('categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('state_filter_categories');
    }
};
