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
        Schema::create('private_notices', function (Blueprint $table) {
            $table->bigIncrements('private_notice_id');
            $table->string('private_notice_name', 100)->index();
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
        Schema::dropIfExists('private_notices');
    }
};
