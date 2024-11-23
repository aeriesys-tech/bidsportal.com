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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->bigIncrements('subscription_plan_id'); 
            $table->string('plan'); 
            $table->decimal('price', 8, 2); 
            $table->integer('days'); 
            $table->integer('month'); 
            $table->string('description'); 
            $table->decimal('discount', 8, 2); 
            $table->timestamps(); 
        });

        DB::table('subscription_plans')->insert([
            [
                'plan' => 'Monthly',
                'price' => 36,
                'days' => 30,
                'month' => 1,
                'description' => 'One Month',
                'discount' => 0
            ],
            [
                'plan' => 'Semi-Annual',
                'price' => 192,
                'days' => 180,
                'month' => 6,
                'description' => 'Six Months',
                'discount' => 27
            ],
            [
                'plan' => 'Annual',
                'price' => 365,
                'days' => 365,
                'month' => 12,
                'description' => 'One Year',
                'discount' => 73
            ]

        ]);   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
