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
        Schema::create('user_state_interests', function (Blueprint $table) {
            $table->id('user_state_interest_id');
            $table->foreignId('user_id')->onDelete('cascade')->index();
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreignId('state_tender_id')->onDelete('cascade')->index();
            $table->foreign('state_tender_id')->references('state_tender_id')->on('state_tenders');
            $table->string('interest_type', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_state_interests');
    }
};
