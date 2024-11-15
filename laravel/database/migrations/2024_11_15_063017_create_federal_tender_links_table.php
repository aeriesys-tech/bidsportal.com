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
        Schema::create('federal_tender_links', function (Blueprint $table) {
            $table->bigIncrements('federal_tender_link_id');
            $table->foreignId('federal_tender_id')->onDelete('cascade')->index();
            $table->foreign('federal_tender_id')->references('federal_tender_id')->on('federal_tenders');
            $table->string('rel', 50)->nullable();
            $table->text('href')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('federal_tender_links');
    }
};
