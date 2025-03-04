<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Jobs\TransferFederalTenderJob;
use Illuminate\Support\Facades\DB;
use App\Jobs\TransferStateTenderJob;
use Illuminate\Support\Facades\Log;

class DatabaseController extends Controller
{
    public function transferFederalTenders()
    {
        DB::connection('target_db')->table('tbl_tender')->where('tdr_region', 2)
        ->orderBy('tdr_no')->chunk(100, function ($tenders) {
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
                    'tdr_documents' => $tbl->tdr_documents,
                    'tdr_documents_date' => $tbl->tdr_documents_date,
                    'tdr_documents_size' => $tbl->tdr_documents_size,
                    'tdr_contracting_office_address' => $tbl->tdr_contracting_office_address,
                    'point_of_contact' => $tbl->point_of_contact
                ];
            })->toArray();

            TransferFederalTenderJob::dispatch($jobData);
        });
        return response()->json(['message' => 'Federal Tender job dispatched successfully.'], 200);
    }

    public function transferStateTenders()
    {
        DB::connection('target_db')->table('tbl_tender')->where('tdr_region', 1)
        ->orderBy('tdr_no')->chunk(100, function ($tenders) {
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
                    'tdr_documents' => $tbl->tdr_documents,
                    'tdr_documents_date' => $tbl->tdr_documents_date,
                    'tdr_documents_size' => $tbl->tdr_documents_size,
                    'tdr_documents' => $tbl->tdr_documents,
                    'tdr_documents_date' => $tbl->tdr_documents_date,
                    'tdr_documents_size' => $tbl->tdr_documents_size,
                    'tdr_contracting_office_address' => $tbl->tdr_contracting_office_address,
                    'point_of_contact' => $tbl->point_of_contact
                ];
            })->toArray();

            TransferStateTenderJob::dispatch($jobData);
        });
        return response()->json(['message' => 'State Tender job dispatched successfully.'], 200);
    }

    public function transferUsersData()
    {
        $users = DB::connection('bidsp4h0_bids_n')->table('tbl_users')->get();
        foreach ($users as $key => $user) {
            Log::info($user);
            // $user_data = DB::connection('mysql')->table('users')->create([
            //     'name' => 
            //     'email' => 
            //     'password' => 
            //     'position' => 
            //     'company_name' => 
            //     'phone' => 
            //     'web_address' => 
            //     'mailing_adress' => 
            //     'city' => 
            //     'state' => 
            //     'pin_code' => 
            //     'status' => 
            //     'pw' => 

            // ]);
        }

        // ->where('tdr_region', 1)
        // ->orderBy('tdr_no')->chunk(100, function ($tenders) {
        //     $jobData = $tenders->map(function ($tbl) {
        //         return [
        //             'tdr_no' => $tbl->tdr_no,
        //             'tdr_title' => $tbl->tdr_title,
        //             'tdr_desc' => $tbl->tdr_desc,
        //             'tdr_opening_date' => $tbl->tdr_opening_date,
        //             'tdr_posted_date' => $tbl->tdr_posted_date,
        //             'tdr_expiry_date' => $tbl->tdr_expiry_date,
        //             'tdr_country_id' => $tbl->tdr_country_id,
        //             'tdr_state_id' => $tbl->tdr_state_id,
        //             'tdr_type' => $tbl->tdr_type,
        //             'tdr_notice' => $tbl->tdr_notice,
        //             'tdr_category' => $tbl->tdr_category,
        //             'tdr_agency' => $tbl->tdr_agency,
        //             'tdr_set_aside_status' => $tbl->tdr_set_aside_status,
        //             'tdr_naics' => $tbl->tdr_naics,
        //             'tdr_psc' => $tbl->tdr_psc,
        //             'tdr_posting_link' => $tbl->tdr_posting_link,
        //             'tdr_doc_fees' => $tbl->tdr_doc_fees,
        //             'tdr_type_of_award' => $tbl->tdr_type_of_award,
        //             'tdr_place_of_performance' => $tbl->tdr_place_of_performance,
        //             'noticeId' => $tbl->noticeId,
        //             'description_link' => $tbl->description_link,
        //             'tdr_documents' => $tbl->tdr_documents,
        //             'tdr_documents_date' => $tbl->tdr_documents_date,
        //             'tdr_documents_size' => $tbl->tdr_documents_size,
        //             'tdr_documents' => $tbl->tdr_documents,
        //             'tdr_documents_date' => $tbl->tdr_documents_date,
        //             'tdr_documents_size' => $tbl->tdr_documents_size,
        //             'tdr_contracting_office_address' => $tbl->tdr_contracting_office_address,
        //             'point_of_contact' => $tbl->point_of_contact
        //         ];
        //     })->toArray();

            // TransferStateTenderJob::dispatch($jobData);
        // });
        return response()->json(['message' => 'success'], 200);
    }
}
