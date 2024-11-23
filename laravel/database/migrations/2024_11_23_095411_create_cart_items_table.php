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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->bigIncrements('cart_item_id');
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreignId('federal_tender_id')->nullable();
            $table->foreign('federal_tender_id')->references('federal_tender_id')->on('federal_tenders');
            $table->foreignId('state_tender_id')->nullable();
            $table->foreign('state_tender_id')->references('state_tender_id')->on('state_tenders');
            $table->string('region', 20);
            $table->decimal('fees', 8, 2);
            $table->date('cart_item_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
