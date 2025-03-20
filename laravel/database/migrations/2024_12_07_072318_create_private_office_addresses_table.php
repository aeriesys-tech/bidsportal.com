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
        Schema::create('private_office_addresses', function (Blueprint $table) {
            $table->id('private_office_address_id');
            $table->foreignId('private_tender_id')->onDelete('cascade')->index();
            $table->foreign('private_tender_id')->references('private_tender_id')->on('private_tenders');
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
        Schema::dropIfExists('private_office_addresses');
    }
};
