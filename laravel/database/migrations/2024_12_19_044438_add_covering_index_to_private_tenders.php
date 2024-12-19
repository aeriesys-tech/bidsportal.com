<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**s
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('private_tenders', function (Blueprint $table) {
            $table->index(['private_notice_id', 'posted_date'], 'index_notice_posted');
            $table->index(['private_notice_id', 'expiry_date'], 'index_notice_expiry');
            $table->index(['private_notice_id', 'state_id'], 'index_notice_private');
            $table->index(['private_notice_id', 'private_agency_id'], 'index_notice_agency');
            $table->index(['private_notice_id', 'posted_date', 'expiry_date'], 'index_notice_posted_expiry');
            $table->index(['private_notice_id', 'posted_date', 'expiry_date', 'state_id'], 'index_notice_posted_expiry_set_private');
            $table->index(['private_notice_id', 'posted_date', 'expiry_date', 'state_id', 'private_agency_id'], 'index_notice_posted_expiry_set_private_agency');
            $table->index([ 'state_id', 'private_agency_id'], 'index_private_set_agency');
            DB::statement('CREATE INDEX private_tenders_tender_no_title_index ON private_tenders (tender_no(50), title(50))');
            $table->fullText(['tender_no', 'title'], 'idx_tender_fulltext');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('private_tenders', function (Blueprint $table) {
            //
        });
    }
};
