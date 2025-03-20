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
        Schema::create('international_notices', function (Blueprint $table) {
            $table->bigIncrements('international_notice_id');
            $table->string('international_notice_name', 100)->index();
            $table->integer('sort')->nullable()->index();
            $table->string('background_color', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('international_notices');
    }
};
