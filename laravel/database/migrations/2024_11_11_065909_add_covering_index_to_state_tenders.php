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
        Schema::table('state_tenders', function (Blueprint $table) {
            $table->index(['state_notice_id', 'posted_date'], 'index_notice_posted');
            $table->index(['state_notice_id', 'expiry_date'], 'index_notice_expiry');
            $table->index(['state_notice_id', 'set_aside_id'], 'index_notice_set_aside');
            $table->index(['state_notice_id', 'state_id'], 'index_notice_state');
            $table->index(['state_notice_id', 'state_agency_id'], 'index_notice_agency');
            $table->index(['state_notice_id', 'posted_date', 'expiry_date'], 'index_notice_posted_expiry');
            $table->index(['state_notice_id', 'posted_date', 'expiry_date', 'state_id'], 'index_notice_posted_expiry_set_state');
            $table->index(['state_notice_id', 'posted_date', 'expiry_date', 'state_id', 'state_agency_id'], 'index_notice_posted_expiry_set_state_agency');
            $table->index([ 'state_id', 'state_agency_id'], 'index_state_set_agency');
            DB::statement('CREATE INDEX state_tenders_tender_no_title_index ON state_tenders (tender_no(50), title(50))');
            $table->fullText(['tender_no', 'title'], 'idx_tender_fulltext');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('state_tenders', function (Blueprint $table) {
            //
        });
    }
};
