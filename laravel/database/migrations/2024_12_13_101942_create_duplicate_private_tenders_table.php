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
        Schema::create('duplicate_private_tenders', function (Blueprint $table) {
            $table->id('duplicate_private_tender_id');
            $table->string('tender_no', 100);
            $table->date('posted_date');
            $table->text('title');
            $table->text('tender_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('duplicate_private_tenders');
    }
};
