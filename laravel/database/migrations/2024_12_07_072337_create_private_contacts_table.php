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
        Schema::create('private_contacts', function (Blueprint $table) {
            $table->id('private_contact_id');
            $table->foreignId('private_tender_id')->onDelete('cascade')->index();
            $table->foreign('private_tender_id')->references('private_tender_id')->on('private_tenders');
            $table->string('type', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('title', 255)->nullable();
            $table->text('full_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_office_contacts');
    }
};
