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
        Schema::create('international_attachments', function (Blueprint $table) {
            $table->id('international_attachment_id');
            $table->foreignId('international_tender_id')->onDelete('cascade')->index();
            $table->foreign('international_tender_id')->references('international_tender_id')->on('international_tenders');
            $table->text('attachment_name');
            $table->string('attachment_size', 100)->nullable();
            $table->date('attachment_date')->nullable();
            $table->text('attachment_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('international_attachments');
    }
};
