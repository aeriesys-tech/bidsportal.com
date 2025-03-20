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
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->bigIncrements('purchase_item_id');
            $table->foreignId('user_payment_id');
            $table->foreign('user_payment_id')->references('user_payment_id')->on('user_payments');
            $table->foreignId('federal_tender_id')->nullable();
            $table->foreign('federal_tender_id')->references('federal_tender_id')->on('federal_tenders');
            $table->foreignId('state_tender_id')->nullable();
            $table->foreign('state_tender_id')->references('state_tender_id')->on('state_tenders');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};
