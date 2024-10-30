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
            $table->index(['federal_notice_id', 'posted_date'], 'index_notice_posted');
            $table->index(['federal_notice_id', 'expiry_date'], 'index_notice_expiry');
            $table->index(['federal_notice_id', 'naics_id'], 'index_notice_naics');
            $table->index(['federal_notice_id', 'psc_id'], 'index_notice_psc');
            $table->index(['federal_notice_id', 'set_aside_id'], 'index_notice_set_aside');
            $table->index(['federal_notice_id', 'state_id'], 'index_notice_state');
            $table->index(['federal_notice_id', 'federal_agency_id'], 'index_notice_agency');
            $table->index(['federal_notice_id', 'posted_date', 'expiry_date'], 'index_notice_posted_expiry');
            $table->index(['federal_notice_id', 'posted_date', 'expiry_date', 'naics_id'], 'index_notice_posted_expiry_naics');
            $table->index(['federal_notice_id', 'posted_date', 'expiry_date', 'naics_id', 'psc_id'], 'index_notice_posted_expiry_naics_psc');
            $table->index(['federal_notice_id', 'posted_date', 'expiry_date', 'naics_id', 'psc_id', 'set_aside_id'], 'index_notice_posted_expiry_naics_psc_set');
            $table->index(['federal_notice_id', 'posted_date', 'expiry_date', 'naics_id', 'psc_id', 'set_aside_id', 'state_id'], 'index_notice_posted_expiry_naics_psc_set_state');
            $table->index(['federal_notice_id', 'posted_date', 'expiry_date', 'naics_id', 'psc_id', 'set_aside_id', 'state_id', 'federal_agency_id'], 'index_notice_posted_expiry_naics_psc_set_state_agency');

            // $table->index(['posted_date', 'expiry_date'], 'index_posted_expiry');
            // $table->index(['posted_date', 'naics_id'], 'index_posted_naics');
            // $table->index(['posted_date', 'psc_id'], 'index_posted_psc');
            // $table->index(['psc_id', 'state_id'], 'index_psc_state');
            // $table->index(['posted_date', 'set_aside_id'], 'index_posted_set_aside');
            // $table->index(['posted_date', 'federal_agency_id'], 'index_posted_agency');
            // $table->index(['posted_date', 'expiry_date', 'naics_id'], 'index_posted_expiry_naics');
            // $table->index(['posted_date', 'expiry_date', 'naics_id', 'psc_id'], 'index_posted_expiry_naics_psc');
            // $table->index(['posted_date', 'expiry_date', 'naics_id', 'psc_id', 'state_id'], 'index_posted_expiry_naics_psc_state');
            // $table->index(['posted_date', 'expiry_date', 'naics_id', 'psc_id', 'state_id', 'federal_agency_id'], 'index_posted_expiry_naics_psc_state_agency');

            // $table->index(['expiry_date', 'naics_id'], 'index_expiry_naics');
            // $table->index(['expiry_date', 'psc_id'], 'index_expiry_psc');
            // $table->index(['expiry_date', 'state_id'], 'index_expiry_state');
            // $table->index(['expiry_date', 'set_aside_id'], 'index_expiry_set_aside');
            // $table->index(['expiry_date', 'federal_agency_id'], 'index_expiry_agency');
            // $table->index(['expiry_date', 'naics_id', 'psc_id'], 'index_expiry_naics_psc');
            // $table->index(['expiry_date', 'naics_id', 'psc_id', 'state_id'], 'index_expiry_naics_psc_state');
            // $table->index(['expiry_date', 'naics_id', 'psc_id', 'state_id', 'set_aside_id'], 'index_expiry_naics_psc_state_set');
            // $table->index(['expiry_date', 'naics_id', 'psc_id', 'state_id', 'set_aside_id', 'federal_agency_id'], 'index_expiry_naics_psc_state_set_agency');

            $table->index(['naics_id', 'psc_id'], 'index_naics_psc');
            $table->index(['naics_id', 'state_id'], 'index_naics_state');
            $table->index(['naics_id', 'set_aside_id'], 'index_naics_set_aside');
            $table->index(['naics_id', 'federal_agency_id'], 'index_naics_agency');
            $table->index(['naics_id', 'psc_id', 'state_id'], 'index_naics_psc_state');
            $table->index(['naics_id', 'psc_id', 'state_id', 'set_aside_id'], 'index_naics_psc_state_set');
            $table->index(['naics_id', 'psc_id', 'state_id', 'set_aside_id', 'federal_agency_id'], 'index_naics_psc_state_set_agency');

            $table->index(['psc_id', 'state_id'], 'index_psc_state');
            $table->index(['psc_id', 'set_aside_id'], 'index_psc_set_aside');
            $table->index(['psc_id', 'federal_agency_id'], 'index_psc_agency');
            $table->index(['psc_id', 'state_id', 'set_aside_id'], 'index_psc_state_set');
            $table->index(['psc_id', 'state_id', 'set_aside_id', 'federal_agency_id'], 'index_psc_state_set_agency');

            // $table->index(['state_id', 'set_aside_id'], 'index_state_set_aside');
            // $table->index(['state_id', 'federal_agency_id'], 'index_state_agency');
            // $table->index(['state_id', 'set_aside_id', 'federal_agency_id'], 'index_state_set_aside_agency');

            // $table->index(['set_aside_id', 'federal_agency_id'], 'index_set_aside_agency');

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
