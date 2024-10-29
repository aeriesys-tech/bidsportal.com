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
            $table->index(['posted_date', 'expiry_date', 'federal_notice_id', 'naics_id', 'psc_id', 'set_aside_id', 'state_id', 'federal_agency_id'], 'covering_index_federal_tenders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('federal_tenders', function (Blueprint $table) {
            //
        });
    }
};
