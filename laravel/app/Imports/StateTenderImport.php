<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Log;
use App\Models\StateTender;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\Country;
use App\Models\State;
use App\Models\StateAttachment;
use App\Models\DuplicateStateTender;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use App\Rules\ValidDateRule; 
use GuzzleHttp\Client;
use Storage;
use App\Models\StateNotice;
use App\Models\StateAgency;
use App\Models\Category;
use App\Models\StateContact;
use App\Models\StateOfficeAddress;
use Illuminate\Support\Facades\DB;
use Google\Client as GoogleClient;
use Google\Service\SearchConsole;

class StateTenderImport implements ToCollection
{
    protected $existing_tender_nos;
    protected $folder_path;
    protected $s3_folder;

    public function __construct($folder_path, $s3_folder, $file)
    {
        $this->existing_tender_nos = StateTender::pluck('tender_no')->toArray();
        $this->folder_path = $folder_path;
        $this->s3_folder = $s3_folder;
        $this->file = $file;
    }

    public function getFileSizeWithGuzzle($url) {
        $client = new Client();
        try {
            $response = $client->head($url);
            $fileSize = $response->getHeader('Content-Length');
            return $fileSize ? (int) $fileSize[0] : null;
        } catch (\Exception $e) {
            return null; // or handle error
        }
    }
    
    public function collection(Collection $rows)
    {
        $s3 = Storage::disk('s3')->getClient();
        $bucket = config('app.AWS_BUCKET');
        foreach ($rows as $key => $row) {
            Log::info($row[1]);
        	if ($row->count() !== 19) {
	            Log::error("File {$key} has an incorrect number of columns.");
	            throw new \Exception("File {$this->file} has an incorrect number of columns. Expected 19 columns got {$row->count()}.");
	        }
            if($row[1] != 'Posted Date'){
            	$posted_date = date('Y-m-d H:i:s');
                $opening_date = $this->parseDate($row[1]);
                $expiry_date = $this->parseDate($row[2]);
                $tender_url = $row[16];
                $tender_no = $row[5];
                $tender_number = str_replace($row[5], '-', '');
                $title = $row[6] ?? 'No Title';

                $state_notice = StateNotice::where(function ($query) use($row) {
                    $query->where(DB::raw('LOWER(notice_name)'), $row[4]);
                })->first();
                $state_notice_id = $state_notice->state_notice_id ?? null;

                $state_agency = StateAgency::where(function ($query) use($row) {
                    $query->where(DB::raw('LOWER(state_agency_name)'), $row[8]);
                })->first();
                $state_agency_id = $state_agency->state_agency_id ?? null;

                $category = Category::where(function ($query) use($row) {
                    $query->where(DB::raw('LOWER(category_name)'), $row[11]);
                })->first();
                $category_id = $category->category_id ?? null;

                $state = State::where(function ($query) use($row) {
                    $query->where(DB::raw('LOWER(state_name)'), $row[18]);
                })->first();
                $state_id = $state->state_id ?? null;

                // if (in_array($tender_no, $this->existing_tender_nos)) {
                //     if($tender_no){
                //         DuplicateStateTender::updateOrCreate([
                //             'tender_no' => $tender_no,
                //             'posted_date' => $posted_date,
                //             'title' => $title,
                //             'tender_url' => $tender_url
                //         ]);
                //     }
                //     continue;
                // }
                // if($title && $tender_no){
                //     $sitemap_url = "/bids/state-opportunities/".$title."-".$tender_no;
                //     $this->submitToGoogle($sitemap_url);
                // }

                $country = Country::where('country_code', 'US')->first();
                $description = (!empty($row[12]) ? $row[12] : '') . (!empty($row[13]) ? ' ' . $row[13] : '');
                $notice_name = $row[3]?$row[3]:null;
                $category_name = $row[9]?$row[9]:null;
                $agency_name = $row[7]?$row[7]:null;
                $contracting_office_address = !empty($row[14]) ? $row[14] : '';
                // $contract_information = !empty($row[15]) ? explode("|", $row[15]) : [];
                $contract_information = !empty($row[15]) ? array_map('trim', explode("|", $row[15])) : [];
                $tdr_fees = 0;

                if($opening_date && $expiry_date && $state_notice_id && $state_agency_id && $state_id){
                    $status = true;
                }else{
                    $status = false;
                }

                if($tender_no && $expiry_date && $title){
                    try{
                        $state_tender = StateTender::updateOrCreate(
                            [   'tender_no' => $tender_no ],
                            [
                                'tender_number' => $tender_number,
                                'title' => $title,
                                'description' => $description,
                                'opening_date' => $opening_date,
                                'posted_date' => $posted_date,
                                'expiry_date' => $expiry_date,
                                'country_id' => $country->country_id,
                                'state_id' => $state_id,
                                'tender_type_id' => null,
                                'state_notice_id' => $state_notice_id,
                                'category_id' => $category_id,
                                'state_agency_id' => $state_agency_id,
                                'tender_url' => $tender_url,
                                'notice_id' => null,
                                'description_link' => null,
                                'category_name' => $category_name,
                                'notice_name' => $notice_name,
                                'agency_name' => $agency_name,
                                'document_path' => null,
                                'status' => $status,
                                'contracting_office_address' => $contracting_office_address,
                                'upload_type' => 'auto'
                            ]);
                        Log::info("file". $this->file);
                        Log::info("contact_info". count($contract_information));
                        Log::info("tender_no". $tender_no);
                        if ($state_tender && count($contract_information) >= 4) {
                            $state_office_address = StateContact::create([
                                'state_tender_id' => $state_tender->state_tender_id,
                                'type' => 'Primary',
                                'full_name' => $contract_information[0] ?? null,  
                                'title' => $contract_information[1] ?? null,
                                'phone' => $contract_information[2] ?? null,
                                'email' => $contract_information[3] ?? null
                            ]);
                        }
                        $tender_attachments = $row[17]?$row[17]:null;
                        $filenames = [];
                        if (str_contains($tender_attachments, ',')){
                            $filenames = explode(',', $tender_attachments);
                        }else {
                            $filenames = [$tender_attachments];
                        }
                        if($state_tender){
                            foreach ($filenames as $filename) {
                                if ($filename) {
                                    $file_path = "State/attachments/{$this->s3_folder}/{$tender_no}/" . trim($filename);

                                    try {
                                        $result = $s3->headObject([
                                            'Bucket' => $bucket,
                                            'Key' => $file_path
                                        ]);

                                        $attachment_url = Storage::disk('s3')->url($file_path);
                                        $attachment_size = $result['ContentLength'] ?? null;
                                    } catch (\Exception $e) {
                                        $attachment_url = null;
                                        $attachment_size = null;
                                    }

                                    StateAttachment::updateOrCreate(
                                        [
                                            'state_tender_id' => $state_tender->state_tender_id,
                                            'attachment_name' => $filename,
                                        ],
                                        [
                                            'attachment_size' => $attachment_size,
                                            'attachment_date' => $this->s3_folder,
                                            'attachment_url' => $attachment_url
                                        ]
                                    );
                                }
                            }
                        }
                    } catch (\Exception $e){
                        Log::error("Error processing state tender: " . $e->getMessage());
                    }
                }
            }
        }
    }

    private function parseDate($value)
    {
        try {
            if($value){
                if (is_numeric($value)) {
                    return Date::excelToDateTimeObject($value)->format('Y-m-d');
                } else if (is_string($value) && strtotime($value)) {
                    return Carbon::createFromFormat('Y-m-d', $value)->format('Y-m-d');
                }else{
                    return null;
                }
            }else{
                return null;
            }
        } catch (\Exception $e) {
            Log::error("Date parsing error: " . $e->getMessage());
            return null;
        }
    }

    public function startRow(): int
    {
        return 2; 
    }

    public function rules(): array
    {
        return [
            '*.0' => 'required',                  
            '*.1' => ['nullable', new ValidDateRule], 
            '*.2' => ['required', new ValidDateRule], 
            '*.3' => 'nullable',
            '*.4' => 'nullable',
            '*.5' => 'required',
            '*.6' => 'nullable',
            '*.7' => 'nullable',
            '*.8' => 'nullable',
            '*.9' => 'nullable',
            '*.10' => 'nullable',
            '*.11' => 'nullable',
            '*.12' => 'nullable',
            '*.13' => 'nullable',
            '*.14' => 'nullable',
            '*.15' => 'nullable',
            '*.16' => 'nullable',
            '*.17' => 'nullable',
            '*.18' => 'nullable',
        ];
    }

    public function submitToGoogle($sitemap_url)
    {
        try {
            $client = new GoogleClient();
            $client->setAuthConfig(storage_path('app/google/client_secret.json')); // Ensure this file exists
            $client->addScope(SearchConsole::WEBMASTERS_READONLY);
            $client->setAccessType('offline');

            $searchConsole = new SearchConsole($client);
            $siteUrl = config('app.url'); // Change this if needed

            $searchConsole->sitemaps->submit($siteUrl, $sitemap_url);

            Log::info("Sitemap submitted successfully: " . $sitemap_url);
        } catch (\Exception $e) {
            Log::error("Failed to submit sitemap: " . $e->getMessage());
        }
    }

}
