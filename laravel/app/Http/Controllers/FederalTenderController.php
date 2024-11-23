<?php

namespace App\Http\Controllers;
use App\Models\FederalTender;
use App\Models\User;
use App\Models\FederalAttachment;
use App\Http\Resources\FederalTenderResource;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\FederalTenderMail;
use App\Http\Resources\FederalTenderDetailResource;
use GuzzleHttp\Client;
use DateTime;
use DateTimeZone;
use App\Models\ApiKey;
use ZipArchive;
use Auth;

class FederalTenderController extends Controller
{
    public function addAttachments($resource_links){
        foreach ($resource_links as $key => $attachment) {
            $client = new Client();  
            $response = $client->get($attachment); 
            $header=$response->getheaders();
            if(isset($header['Last-Modified']) && count($header['Last-Modified']) > 0){
                $dt = new DateTime($header['Last-Modified'][0], new DateTimeZone('UTC'));
                $last_modified = $dt->format('M d, Y');    
                
            }else{
                $last_modified = null;
            }
        }
    }

    public function updateDescriptions()
    {
        $api_key = ApiKey::first()?->api_key ?? "8UPYOoBOM5C3ZSFpaxt1sIvZ3byn2Jfb91XoGyMT";
        $federal_tenders = FederalTender::whereNull('description')->limit(4)->get();
        if ($federal_tenders->isEmpty()) {
            \Log::info('No federal tenders found with null descriptions.');
            return;
        }

        $client = new Client();
        foreach ($federal_tenders as $federal_tender) {
            try {
                $url = $federal_tender['description_link'] . "&api_key=" . $api_key;

                $response = $client->get($url);
                $responseBody = json_decode($response->getBody(), true);

                $description = $responseBody['description'] ?? null;

                if ($description) {
                    $federal_tender->update(['description' => $description]);
                }

            } catch (\GuzzleHttp\Exception\ClientException $e) {
                \Log::error("Error fetching description for tender ID: {$federal_tender['federal_tender_id']} - " . $e->getMessage());
            } catch (\Exception $e) {
                \Log::error("Unexpected error for tender ID: {$federal_tender['federal_tender_id']} - " . $e->getMessage());
            }
        }
    }


    public function paginateFederalTenders(Request $request)
    {
    	$request->validate([
            'order_by' => 'required',
            'per_page' => 'required|numeric'
        ]);
    	$query = FederalTender::query();

        if ($request->active && $request->expired) {
            $query->whereDate('expiry_date', '>=', now()->toDateString())
              ->orWhereDate('expiry_date', '<', now()->toDateString());
        } elseif ($request->active) {
            $query->whereDate('expiry_date', '>=', now()->toDateString());
        } elseif ($request->expired) {
            $query->whereDate('expiry_date', '<', now()->toDateString());
        }

    	if($request->posted_date && $request->posted_date != 'custom'){
            $previous_date = Carbon::now()->sub(CarbonInterval::createFromDateString($request->posted_date))->format('Y-m-d');
    		$query->whereDate('posted_date', '>=', $previous_date);
    	}

        if($request->posted_from_date && $request->posted_to_date){
            $query->whereDate('posted_date', '>=', $request->posted_from_date)->whereDate('posted_date', '<=', $request->posted_to_date);
        }

        if($request->response_date && $request->response_date != 'custom'){
            $next_date = Carbon::now()->add(CarbonInterval::createFromDateString($request->response_date))->format('Y-m-d');
            $query->whereDate('expiry_date', '<=', $next_date);
        }

        if($request->response_from_date && $request->response_to_date){
            $query->whereDate('expiry_date', '>=', $request->response_from_date)->whereDate('expiry_date', '<=', $request->response_to_date);
        }

    	if(!empty($request->federal_notices)){
    		$query->whereIn('federal_notice_id', $request->federal_notices);
    	}

    	if(!empty($request->naics)){
    		$query->whereIn('naics_id', $request->naics);
    	}

    	if(!empty($request->pscs)){
    		$query->whereIn('psc_id', $request->pscs);
    	}

        if(!empty($request->set_asides)){
            $query->whereIn('set_aside_id', $request->set_asides);
        }

        if(!empty($request->states)){
            $query->whereIn('state_id', $request->states);
        }

        if(!empty($request->federal_agencies)){
            $query->whereIn('federal_agency_id', $request->federal_agencies);
        }

    	if (!empty($request->keywords)) {
            if (is_string($request->keywords)) {
                $keywords = array_map('trim', explode(',', $request->keywords));
            } else {
                $keywords = array_map('trim', $request->keywords);
            }

            $searchQuery = implode(' ', $keywords); // Join keywords for full-text search

            // Search for matches
            $query->whereRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$searchQuery]);

            $query->orderByRaw("MATCH(tender_no, title) AGAINST(? IN NATURAL LANGUAGE MODE) DESC, federal_tender_id DESC", [$searchQuery]);
        }


	    $query->orderBy('federal_tender_id', 'DESC');
    	$federal_tenders = $query->paginate($request->per_page); 
        return FederalTenderResource::collection($federal_tenders);
    }

    public function getFederalTender(Request $request)
    {
        $federal_tender = FederalTender::where('federal_tender_id', $request->federal_tender_id)->first();
        return new FederalTenderDetailResource($federal_tender);
    }

    public function sendFederalTenderMail(Request $request)
    {
        $data = $request->validate([
            'recipient_email' => ['required', function ($attribute, $value, $fail) {
                $emails = array_map('trim', explode(',', $value));
                foreach ($emails as $email) {
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $fail("The $attribute contains an invalid email: $email");
                    }
                }
            }],
            'subject' => 'required',
            'message' => 'required',
            'federal_tenders' => 'required|array'
        ]);

        if(isset($request->federal_tenders) && !empty($request->federal_tenders)){
            $bids = FederalTender::whereIn('federal_tender_id', $request->federal_tenders)->get();
            $user = Auth::User();
            $emails = array_map('trim', explode(',', $request->recipient_email));
            Mail::to($emails)->send(new FederalTenderMail($bids, $user, $request));

            return response()->json(['status' => 'Email sent successfully!']);
        }else{
            return response()->json(['status' => 'Error sending mail'], 422);
        }
    }

    public function downloadFederalAttachments($federal_tender_id)
    {
        $federal_attachments = FederalAttachment::where('federal_tender_id', $federal_tender_id)->get();
        if(count($federal_attachments)){
            
            $zip_file_name = 'attachments.zip';
            $temp_zip_path = storage_path($zip_file_name);
            $zip = new ZipArchive;
            if ($zip->open($temp_zip_path, ZipArchive::CREATE) === TRUE) {
                foreach ($federal_attachments as $federal_attachment) {
                    $file_contents = file_get_contents($federal_attachment->attachment_url); 
                    $file_name = basename($federal_attachment->attachment_url); 
                    $zip->addFromString($file_name, $file_contents);
                }
                $zip->close();
            } else {
                return response()->json(['error' => 'Failed to create ZIP file'], 500);
            }
            return response()->download($temp_zip_path, $zip_file_name)->deleteFileAfterSend(true);
        }   
    }
}
