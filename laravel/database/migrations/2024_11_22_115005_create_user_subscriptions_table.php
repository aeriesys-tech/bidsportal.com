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
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('user_subscription_id');
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->string('order_id', 20)->nullable();
            $table->string('payment_method', 50)->nullable();
            $table->string('active_status', 50)->nullable();
            $table->integer('validity')->nullable();
            $table->datetime('valid_from')->nullable();
            $table->datetime('valid_to')->nullable();
            $table->string('item_number')->nullable();
            $table->string('txn_id')->nullable();
            $table->string('ipn_track_id')->nullable();
            $table->decimal('payment_gross', 8,2)->nullable();
            $table->string('currency_code', 10)->nullable();
            $table->foreignId('subscription_plan_id');
            $table->foreign('subscription_plan_id')->references('subscription_plan_id')->on('subscription_plans');
            $table->string('payer_email', 50)->nullable();
            $table->string('payment_status', 50)->nullable();
            $table->string('subscr_month', 10)->nullable();
            $table->string('payment_date', 100)->nullable();
            $table->date('created_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};
