<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Log;
use App\Models\StateTender;
// use App\Models\DuplicateBid;
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

class StateTenderImport implements ToCollection, WithValidation, WithStartRow
{
    protected $existing_tender_nos;
    protected $folder_path;
    protected $s3_folder;

    public function __construct($folder_path, $s3_folder)
    {
        $this->existing_tender_nos = StateTender::pluck('tender_no')->toArray();
        $this->folder_path = $folder_path;
        $this->s3_folder = $s3_folder;
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
        foreach ($rows as $key => $row) {
            
            // try {
                $created_date = $this->parseDate($row[1]);
                $expiry_date = $this->parseDate($row[2]);
                $tender_url = $row[12];
                $tender_no = $row[4];
                $title = $row[5] ?? 'No Title';

                if (in_array($tender_no, $this->existing_tender_nos)) {
                    DuplicateStateTender::updateOrCreate([
                        'tender_no' => $tender_no,
                        'posted_date' => $created_date,
                        'title' => $title,
                        'tender_url' => $tender_url
                    ]);
                    continue;
                }

                $country = Country::where('country_code', 'US')->first();
                $description = (!empty($row[8]) ? $row[8] : '') . (!empty($row[9]) ? ' ' . $row[9] : '');
                $notice_name = $row[3]?$row[3]:null;
                $category_name = $row[7]?$row[7]:null;
                $agency_name = $row[6]?$row[6]:null;
                $contracting_office_address = (!empty($row[10]) ? $row[10] : '') . (!empty($row[11]) ? ' ' . $row[11] : '');
                $tdr_fees = 0;
                try{
                    $state_tender = StateTender::updateOrCreate(
                        [   'tender_no' => $tender_no ],
                        [
                            'title' => $title,
                            'description' => $description,
                            'opening_date' => $created_date,
                            'posted_date' => $created_date,
                            'expiry_date' => $expiry_date,
                            'country_id' => $country->country_id,
                            'state_id ' => null,
                            'tender_type_id' => null,
                            'state_notice_id' => null,
                            'category_id' => null,
                            'state_agency_id' => null,
                            'tender_url' => $tender_url,
                            'notice_id' => null,
                            'description_link' => null,
                            'category_name' => $category_name,
                            'notice_name' => $notice_name,
                            'agency_name' => $agency_name,
                            'document_path' => null,
                            'status' => false,
                            'contracting_office_address' => $contracting_office_address
                        ]);
                } catch (\Exception $e){
                    Log::error("Error processing state tender: " . $e->getMessage());
                }

                $tender_attachments = $row[13]?$row[13]:null;
                $filenames = [];
                if (str_contains($tender_attachments, ',')){
                    $filenames = explode(',', $tender_attachments);
                }else {
                    $filenames = [$tender_attachments];
                }
                foreach ($filenames as $filename) {
                    if($filename){
                        try{
                            $file_path = 'State/attachments/'.$this->s3_folder.'/'.$tender_no.'/'. trim($filename);
                            Log::info("file_path: " . $file_path);
                            if (Storage::disk('s3')->exists($file_path)) {
                                Log::info("file_path: " . $file_path);
                                $attachment_url = Storage::disk('s3')->url($file_path);
                            }else{
                                $attachment_url = null;
                            }
                            Log::info("attachment_url: " . $attachment_url);
                            StateAttachment::updateOrCreate(
                            [
                                'state_tender_id' => $state_tender->state_tender_id,
                                'attachment_name' => $filename,
                            ],[
                                'attachment_size' => null,
                                'attachment_date' => $this->s3_folder,
                                'attachment_url' => $attachment_url
                            ]);
                        } catch (\Exception $e){
                            Log::error("Error processing attachement State tender id $state_tender->state_tender_id: " . $e->getMessage());
                        }
                    }
                }
            // }catch (\Exception $e) {
            //     Log::error("Error processing row $key: " . $e->getMessage());
            // }
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
            '*.1' => ['required', new ValidDateRule], 
            '*.2' => ['required', new ValidDateRule], 
            '*.3' => 'nullable',
            '*.4' => 'required',
            '*.5' => 'nullable',
            '*.6' => 'nullable',
            '*.7' => 'nullable',
            '*.8' => 'nullable',
            '*.9' => 'nullable',
            '*.10' => 'nullable',
            '*.11' => 'nullable',
            '*.12' => 'required',
            '*.13' => 'nullable',
        ];
    }
}
