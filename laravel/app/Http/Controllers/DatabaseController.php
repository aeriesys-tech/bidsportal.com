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
        DB::connection('bidsportal.com')->table('tbl_tender')->where('tdr_region', 2)
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
        DB::connection('bidsportal.com')->table('tbl_tender')->where('tdr_region', 1)
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
        $users = DB::connection('bidsportal.com')->table('tbl_users')->get();
        foreach ($users as $key => $user) {
            $user_exists = DB::connection('mysql')->table('users')->where('email', $user->email)->first();
            if(!$user_exists){
                $user_id = DB::connection('mysql')->table('users')->insertGetId([
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => $user->password,
                    'position' => $user->title,
                    'company_name' => $user->company_name,
                    'phone' => $user->phone,
                    'web_address' => $user->web_address,
                    'mailing_address' => $user->mail_address,
                    'city' => $user->city,
                    'state' => $user->state,
                    'pin_code' => $user->zipcode,
                    'status' => $user->status === 'Approved' ? 1 : 0,
                    'pw' => $user->password

                ]);
                if($user->socioeconomic_status){
                    $set_asides = explode(",", $user->socioeconomic_status);
                    foreach ($set_asides as $set_aside_id) {
                        $set_aside_old = DB::connection('bidsportal.com')->table('tbl_set_aside_status')->where('status_id', $set_aside_id)->first();
                        if($set_aside_old){
                            $set_aside_new = DB::connection('mysql')->table('set_asides')->where('set_aside_name', 'like', $set_aside_old->status_name)->first();
                            if($set_aside_new){
                                DB::connection('mysql')->table('user_set_asides')->insert([
                                    'user_id' => $user_id,
                                    'set_aside_id' => $set_aside_new->set_aside_id
                                ]);
                            }
                        }
                    }
                    // Log::info('Set asides:', $set_asides);
                }
                $user_subscription_old = DB::connection('bidsportal.com')->table('user_subscriptions')->where('user_id', $user->id)->first();
                if($user_subscription_old){
                    $subscription_plan = DB::connection('mysql')->table('subscription_plans')->where('month', $user_subscription_old->validity)->first();
                    if($subscription_plan){
                        DB::connection('mysql')->table('user_subscriptions')->insert([
                            'user_id' => $user_id,
                            'order_id' => $user_subscription_old->order_id,
                            'payment_method' => $user_subscription_old->payment_method,
                            'active_status' => $user_subscription_old->active_status,
                            'validity' => $user_subscription_old->validity,
                            'valid_from' => $user_subscription_old->valid_from,
                            'valid_to' => $user_subscription_old->valid_to,
                            'item_number' => $user_subscription_old->item_number,
                            'txn_id' => $user_subscription_old->txn_id,
                            'ipn_track_id' => $user_subscription_old->ipn_track_id,
                            'payment_gross' => $user_subscription_old->payment_gross,
                            'currency_code' => $user_subscription_old->currency_code,
                            'subscription_plan_id' => $subscription_plan->subscription_plan_id,
                            'payer_email' => $user_subscription_old->payer_email,
                            'payment_status' => $user_subscription_old->payment_status,
                            'subscr_month' => $user_subscription_old->subscr_month,
                            'payment_date' => $user_subscription_old->payment_date
                        ]);
                    }
                }

            }
        }
    }
}
