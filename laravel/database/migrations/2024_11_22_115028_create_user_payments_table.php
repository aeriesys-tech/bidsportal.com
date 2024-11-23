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
        Schema::create('user_payments', function (Blueprint $table) {
            $table->bigIncrements('user_payment_id');
            $table->string('txn_id', 20)->nullable();
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->string('order_id', 20)->nullable();
            $table->decimal('payment_amount', 8, 2)->nullable();
            $table->string('payment_status', 20)->nullable();
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('business', 100)->nullable();
            $table->string('payer_email', 50)->nullable();
            $table->string('payer_id', 100)->nullable();
            $table->string('receiver_email', 50)->nullable();
            $table->string('receiver_id', 50)->nullable();
            $table->string('item_name', 100)->nullable();
            $table->string('item_number', 100)->nullable();
            $table->date('payment_date')->nullable();
            $table->decimal('payment_gross', 8, 2)->nullable();
            $table->decimal('payment_fee', 8, 2)->nullable();
            $table->string('mc_currency', 20)->nullable();
            $table->datetime('createdtime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_payments');
    }
};
