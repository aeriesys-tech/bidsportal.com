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
        Schema::table('international_tenders', function (Blueprint $table) {
            $table->index(['international_notice_id', 'posted_date'], 'index_notice_posted');
            $table->index(['international_notice_id', 'expiry_date'], 'index_notice_expiry');
            $table->index(['international_notice_id', 'state_id'], 'index_notice_international');
            $table->index(['international_notice_id', 'international_agency_id'], 'index_notice_agency');
            $table->index(['international_notice_id', 'posted_date', 'expiry_date'], 'index_notice_posted_expiry');
            $table->index(['international_notice_id', 'posted_date', 'expiry_date', 'state_id'], 'index_notice_posted_expiry_set_international');
            $table->index(['international_notice_id', 'posted_date', 'expiry_date', 'state_id', 'international_agency_id'], 'index_notice_posted_expiry_set_international_agency');
            $table->index([ 'state_id', 'international_agency_id'], 'index_international_set_agency');
            DB::statement('CREATE INDEX international_tenders_tender_no_title_index ON international_tenders (tender_no(50), title(50))');
            $table->fullText(['tender_no', 'title'], 'idx_tender_fulltext');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('international_tenders', function (Blueprint $table) {
            //
        });
    }
};
