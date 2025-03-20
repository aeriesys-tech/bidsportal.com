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
        Schema::create('private_attachments', function (Blueprint $table) {
            $table->id('private_attachment_id');
            $table->foreignId('private_tender_id')->onDelete('cascade')->index();
            $table->foreign('private_tender_id')->references('private_tender_id')->on('private_tenders');
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
        Schema::dropIfExists('private_attachments');
    }
};
