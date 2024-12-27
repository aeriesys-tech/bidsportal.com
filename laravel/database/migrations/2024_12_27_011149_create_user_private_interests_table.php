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
        Schema::create('user_private_interests', function (Blueprint $table) {
            $table->id('user_private_interest_id');
            $table->foreignId('user_id')->onDelete('cascade')->index();
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreignId('private_tender_id')->onDelete('cascade')->index();
            $table->foreign('private_tender_id')->references('private_tender_id')->on('private_tenders');
            $table->string('interest_type', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_private_interests');
    }
};
