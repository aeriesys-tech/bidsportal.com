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
        Schema::create('federal_tender_logs', function (Blueprint $table) {
            $table->bigIncrements('federal_tender_log_id');
            $table->string('notice_id', 255)->nullable();
            $table->string('tender_no', 255)->nullable();
            $table->text('error', 50)->nullable();
            $table->text('tender_link')->nullable();
            $table->timestamp('posted_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('federal_tender_logs');
    }
};
