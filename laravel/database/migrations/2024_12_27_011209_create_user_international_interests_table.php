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
        Schema::create('user_international_interests', function (Blueprint $table) {
            $table->id('user_international_interest_id');
            $table->foreignId('user_id')->onDelete('cascade')->index();
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreignId('international_tender_id')->onDelete('cascade')->index();
            $table->foreign('international_tender_id')->references('international_tender_id')->on('international_tenders');
            $table->string('interest_type', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_international_interests');
    }
};
