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
        Schema::create('alert_categories', function (Blueprint $table) {
            $table->id('alert_category_id');
            $table->foreignId('alert_id')->onDelete('cascade')->index();
            $table->foreign('alert_id')->references('alert_id')->on('alerts');
            $table->foreignId('category_id')->onDelete('cascade')->index();
            $table->foreign('category_id')->references('category_id')->on('categories');
            $table->timestamps();
        });

        DB::table('subscription_plans')->insert([
            'plan' => 'Trial',
            'price' => 0,
            'days' => 0,
            'month' => 0,
            'description' => 'Trial',
            'discount' => 0
        ]); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alert_categories');
    }
};
