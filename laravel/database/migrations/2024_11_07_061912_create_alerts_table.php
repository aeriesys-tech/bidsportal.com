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
        Schema::create('alerts', function (Blueprint $table) {
            $table->id('alert_id');
            $table->string('alert_title', 50);
            $table->string('region', 50);
            $table->string('frequency', 50);
            $table->foreignId('user_id')->onDelete('cascade')->index();
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->boolean('active')->nullable();
            $table->boolean('expired')->nullable();
            $table->string('posted_date', 50)->nullable();
            $table->datetime('posted_from_date')->nullable();
            $table->datetime('posted_to_date')->nullable();
            $table->string('response_date', 50)->nullable();
            $table->datetime('response_from_date')->nullable();
            $table->datetime('response_to_date')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
