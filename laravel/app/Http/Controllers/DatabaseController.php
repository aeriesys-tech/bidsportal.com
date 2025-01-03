<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Jobs\TransferFederalTenderJob;
use Illuminate\Support\Facades\DB;
use App\Jobs\TransferStateTenderJob;

class DatabaseController extends Controller
{
    public function transferFederalTenders()
    {
        DB::connection('target_db')->table('tbl_tender')->where('tdr_region', 2)
        ->orderBy('tdr_no')->chunk(250, function ($tenders) {
            $jobData = $tenders->map(function ($tbl) {
                return [
                    'tdr_no' => $tbl->tdr_no,
                    'tdr_title' => $tbl->tdr_title,
                    'tdr_desc' => $tbl->tdr_desc,
                    'tdr_opening_date' => $tbl->tdr_opening_date,
                    'tdr_posted_date' => $tbl->tdr_posted_date,
                    'tdr_expiry_date' => $tbl->tdr_expiry_date,
                    'tdr_country_id' => $tbl->tdr_country_id,
                    'tdr_state_id' => $tbl->tdr_state_id,
                    'tdr_type' => $tbl->tdr_type,
                    'tdr_notice' => $tbl->tdr_notice,
                    'tdr_category' => $tbl->tdr_category,
                    'tdr_agency' => $tbl->tdr_agency,
                    'tdr_set_aside_status' => $tbl->tdr_set_aside_status,
                    'tdr_naics' => $tbl->tdr_naics,
                    'tdr_psc' => $tbl->tdr_psc,
                    'tdr_posting_link' => $tbl->tdr_posting_link,
                    'tdr_doc_fees' => $tbl->tdr_doc_fees,
                    'tdr_type_of_award' => $tbl->tdr_type_of_award,
                    'tdr_place_of_performance' => $tbl->tdr_place_of_performance,
                    'noticeId' => $tbl->noticeId,
                    'description_link' => $tbl->description_link,
                ];
            })->toArray();

            TransferFederalTenderJob::dispatch($jobData);
        });
        return response()->json(['message' => 'Federal Tender job dispatched successfully.'], 200);
    }

    public function transferStateTenders()
    {
        DB::connection('target_db')->table('tbl_tender')->where('tdr_region', 2)
        ->orderBy('tdr_no')->chunk(250, function ($tenders) {
            $jobData = $tenders->map(function ($tbl) {
                return [
                    'tdr_no' => $tbl->tdr_no,
                    'tdr_title' => $tbl->tdr_title,
                    'tdr_desc' => $tbl->tdr_desc,
                    'tdr_opening_date' => $tbl->tdr_opening_date,
                    'tdr_posted_date' => $tbl->tdr_posted_date,
                    'tdr_expiry_date' => $tbl->tdr_expiry_date,
                    'tdr_country_id' => $tbl->tdr_country_id,
                    'tdr_state_id' => $tbl->tdr_state_id,
                    'tdr_type' => $tbl->tdr_type,
                    'tdr_notice' => $tbl->tdr_notice,
                    'tdr_category' => $tbl->tdr_category,
                    'tdr_agency' => $tbl->tdr_agency,
                    'tdr_set_aside_status' => $tbl->tdr_set_aside_status,
                    'tdr_naics' => $tbl->tdr_naics,
                    'tdr_psc' => $tbl->tdr_psc,
                    'tdr_posting_link' => $tbl->tdr_posting_link,
                    'tdr_doc_fees' => $tbl->tdr_doc_fees,
                    'tdr_type_of_award' => $tbl->tdr_type_of_award,
                    'tdr_place_of_performance' => $tbl->tdr_place_of_performance,
                    'noticeId' => $tbl->noticeId,
                    'description_link' => $tbl->description_link,
                ];
            })->toArray();

            TransferStateTenderJob::dispatch($jobData);
        });
        return response()->json(['message' => 'State Tender job dispatched successfully.'], 200);
    }
}
