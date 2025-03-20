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
        Schema::table('federal_tenders', function (Blueprint $table) {
            $table->foreignId('contract_type_id')->nullable();
            $table->foreign('contract_type_id')->references('contract_type_id')->on('contract_types');
            $table->foreignId('award_type_id')->nullable();
            $table->foreign('award_type_id')->references('award_type_id')->on('award_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('federal_tenders', function (Blueprint $table) {
            $table->dropColumn('contract_type_id');
            $table->dropColumn('award_type_id');
        });
    }
};
