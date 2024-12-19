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
        Schema::create('private_filter_keywords', function (Blueprint $table) {
            $table->id('private_filter_keyword_id');
            $table->foreignId('private_filter_id')->onDelete('cascade')->index();
            $table->foreign('private_filter_id')->references('private_filter_id')->on('private_filters');
            $table->string('keyword', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_filter_keywords');
    }
};
