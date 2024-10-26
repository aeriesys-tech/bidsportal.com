<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\FederalTender;
use App\Models\FederalAgency;
use App\Models\FederalContact;
use App\Models\FederalOfficeAddress;
use App\Models\FederalAttachment;

class CopyOldToNew extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copy:old-to-new';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy data from bidsportal2 to bidsportal_v2 with different database structures';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $batchSize = 1000;
        $bidsportal2 = DB::connection('mysql_bidsportal2');
        $bidsportal_v2 = DB::connection('mysql_bidsportal_v2');

        // Initialize caches
        $country_cache = [];
        $state_cache = [];
        $tender_type_cache = [];
        $federal_notice_cache = [];
        $category_cache = [];
        $agency_cache = [];
        $set_aside_cache = [];
        $naics_cache = [];
        $psc_cache = [];
        $documents_size = [];
        $documents_date = [];

        $bidsportal2->table('tbl_tender')->orderBy('tdr_id')->where('tdr_region', 2)
            ->chunk($batchSize, function ($rows) use (
                $country_cache, $state_cache, $tender_type_cache, $federal_notice_cache,
                $category_cache, $agency_cache, $set_aside_cache, $naics_cache, $psc_cache, 
                $bidsportal2, $bidsportal_v2 // Pass in the DB connections
            ) {
                foreach ($rows as $row) {
                   $expiry_date = $row->tdr_expiry_date;
                    if ($expiry_date && $expiry_date instanceof Carbon) {
                        //     $expiry_date = $expiry_date->format('Y-m-d H:i:s');
                        // } else {
                        //     $expiry_date = null; // Keep it as null if not valid
                        // }
                            $min_expiry_date = Carbon::now()->addYears(200);
        
                            if ($expiry_date->isGreaterThanOrEqualTo($min_expiry_date)) {
                                $expiry_date = $expiry_date->format('Y-m-d H:i:s');
                        }
                    }
                
                    $title = $row->tdr_title;
                    $description  = $row->tdr_desc;

                    $country_id = $this->getCachedValue(
                        'country_id', 'country_id', $row->tdr_country_id, 
                        $country_cache, 'tbl_country', 'countries', 
                        $bidsportal2, $bidsportal_v2, 'country_name', 'country_name'
                    );

                    $state_id = $this->getCachedValue(
                        'state_id', 'state_id', $row->tdr_state_id, 
                        $state_cache, 'tbl_state', 'states', 
                        $bidsportal2, $bidsportal_v2, 'state_name', 'state_name'
                    );

                    $tender_type_id = $this->getCachedValue(
                        'tdr_type_id', 'tender_type_id', $row->tdr_type, 
                        $tender_type_cache, 'tbl_tender_type', 'tender_types', 
                        $bidsportal2, $bidsportal_v2, 'tdr_type_name', 'tender_type_name'
                    );

                    $federal_notice_id = $this->getCachedValue(
                        'notice_id', 'federal_notice_id', $row->tdr_notice, 
                        $federal_notice_cache, 'tbl_notice', 'federal_notices', 
                        $bidsportal2, $bidsportal_v2, 'notice_type', 'notice_name'
                    );

                    $category_id = $this->getCachedValue(
                        'category_id', 'category_id', $row->tdr_category, 
                        $category_cache, 'tbl_category', 'categories', 
                        $bidsportal2, $bidsportal_v2, 'category_name', 'category_name'
                    );

                    $federal_agency = FederalAgency::where('agency_name', $row->tdr_agency)->first();
                    $federal_agency_id = $federal_agency?$federal_agency->federal_agency_id:null;

                    $set_aside_id = $this->getCachedValue(
                        'status_id', 'set_aside_id', $row->tdr_set_aside_status, 
                        $set_aside_cache, 'tbl_set_aside_status', 'set_asides', 
                        $bidsportal2, $bidsportal_v2, 'status_name', 'set_aside_name'
                    );

                    $naics_id = $this->getCachedValue(
                        'naics_id', 'naics_id', $row->tdr_naics, 
                        $naics_cache, 'naics', 'naics', 
                        $bidsportal2, $bidsportal_v2, 'naics_code', 'naics_code'
                    );

                    $psc_id = $this->getCachedValue(
                        'psc_id', 'psc_id', $row->tdr_psc, 
                        $psc_cache, 'psc', 'pscs', 
                        $bidsportal2, $bidsportal_v2, 'psc_code', 'psc_code'
                    );

                    $contacts = [];
                    if($row->point_of_contact){                  
                        $contacts = json_decode($row->point_of_contact, true);
                    }
                    // Insert into the new database
                    try {
                        $federal_tender = FederalTender::where('notice_id', $row->noticeId)->first();
                        if(!$federal_tender){
                            $federal_tender = FederalTender::create([
                                'notice_id' => $row->noticeId,
                                'tender_no' => $row->tdr_no,
                                'title' => $title,
                                'description' => $description,
                                'opening_date' => $row->tdr_opening_date,
                                'posted_date' => $row->tdr_opening_date,
                                'expiry_date' => $expiry_date,
                                'country_id' => $country_id,
                                'state_id' => $state_id,
                                'tender_type_id' => $tender_type_id,
                                'federal_notice_id' => $federal_notice_id,
                                'category_id' => $category_id,
                                'federal_agency_id' => $federal_agency_id,
                                'set_aside_id' => $set_aside_id,
                                'naics_id' => $naics_id,
                                'psc_id' => $psc_id,
                                'tender_url' => $row->tdr_posting_link,
                                'fees' => $row->tdr_doc_fees,
                                'type_of_award' => $row->tdr_type_of_award,
                                'place_of_performance' => $row->tdr_place_of_performance,
                                'description_link' => $row->description_link,
                                'category_name' => $row->category,
                                'agency_name' => $row->issuing_agency 
                            ]);

                            if (!empty($row->point_of_contact)) {
                                $contacts = json_decode($row->point_of_contact, true);

                                // Ensure $contacts is an array
                                if (json_last_error() === JSON_ERROR_NONE && is_array($contacts) && count($contacts) > 0) {
                                    foreach ($contacts as $contact) {
                                        FederalContact::updateOrCreate([
                                            'federal_tender_id' => $federal_tender->federal_tender_id
                                        ],[
                                            'type' => $contact['type'] ?? null, 
                                            'email' => $contact['email'] ?? null,
                                            'phone' => $contact['phone'] ?? null,
                                            'title' => $contact['title'] ?? null,
                                            'full_name' => $contact['fullName'] ?? null,
                                        ]);
                                    }
                                } else {
                                    Log::warning("Invalid or empty contact data for tender {$row->tdr_no}");
                                }
                            }

                            if (!empty($row->tdr_contracting_office_address)) {
                                $office_address = json_decode($row->tdr_contracting_office_address, true);
                                if (json_last_error() === JSON_ERROR_NONE && $office_address) {
                                    FederalOfficeAddress::updateOrCreate([
                                        'federal_tender_id' => $federal_tender->federal_tender_id 
                                    ],[
                                        'city' => $office_address['city'] ?? null,
                                        'state' => $office_address['state'] ?? null,
                                        'country' => $office_address['countryCode'] ?? null,
                                        'zip_code' => $office_address['zipcode'] ?? null
                                    ]);
                                }
                            }else {
                                Log::warning("Invalid or empty office address data for tender {$row->tdr_no}");
                            }

                            if (!empty($row->tdr_documents_size)) {
                                $documents_size = explode('@', $row->tdr_documents_size);
                            }else{
                                $documents_size = [];
                            }

                            if (!empty($row->tdr_documents_date)) {
                                $documents_date = explode('@', $row->tdr_documents_date);
                            }else{
                                $documents_date = [];
                            }

                            if (!empty($row->tdr_documents)) {
                                $attachments = explode('@', $row->tdr_documents);

                                // Ensure $attachments is an array
                                if (is_array($attachments) && count($attachments) > 0) {
                                    foreach ($attachments as $key => $attachment) {
                                        FederalAttachment::updateOrCreate([
                                            'federal_tender_id' => $federal_tender->federal_tender_id
                                        ],[
                                            'name' => $attachment ?? null, 
                                            'attachment_size' => $documents_size[$key] ?? null,
                                            'attachment_date' => $documents_date[$key] ?? null
                                        ]);
                                    }
                                } else {
                                    Log::warning("Invalid or empty contact data for tender {$row->tdr_no}");
                                }
                            }

                        }        
                                
                    } catch (\Illuminate\Database\QueryException $e) {
                        Log::error("Failed to update or create tender {$row->tdr_no}: " . $e->getMessage());
                    } catch (\Exception $e) {
                        Log::error("An unexpected error occurred while updating or creating tender {$row->tdr_no}: " . $e->getMessage());
                    }
                }
            });
    }

    function getCachedValue($old_field_key, $new_field_key, $field_value, &$cache, $old_table, $new_table, $old_db, $new_db, $old_name, $new_name) {
        // Check if the value is already cached
        if (isset($cache[$field_value])) {
            // Check if the cached old ID matches the current field value
            if ($cache[$field_value]['old_id'] == $field_value) {
                return $cache[$field_value]['new_id'];  // Return the cached new ID
            }
        }

        // If not cached or IDs don't match, fetch from database
        $old_data = $old_db->table($old_table)->where($old_field_key, $field_value)->first();
        if ($old_data) {
            // Find the matching entry in the new database by name or identifier
            $new_data = $new_db->table($new_table)->where($new_name, $old_data->$old_name)->first();
            $new_id = $new_data ? $new_data->$new_field_key : null;

            // Cache the result
            $cache[$field_value] = [
                'old_id' => $field_value,
                'new_id' => $new_id
            ];

            return $new_id;
        }

        return null;  // Return null if no match is found
    }


}
