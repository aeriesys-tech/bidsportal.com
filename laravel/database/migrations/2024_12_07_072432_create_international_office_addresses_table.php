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
        Schema::create('international_office_addresses', function (Blueprint $table) {
            $table->id('international_office_address_id');
            $table->foreignId('international_tender_id')->onDelete('cascade')->index();
            $table->foreign('international_tender_id')->references('international_tender_id')->on('international_tenders');
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('zip_code', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('international_office_addresses');
    }
};
