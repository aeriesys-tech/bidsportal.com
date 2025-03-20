<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class StateAttachmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
    	$precision = 2;
    	if($this->attachment_size){
	    	$units = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
	        $this->attachment_size = max($this->attachment_size, 0);
	        $power = $this->attachment_size > 0 ? floor(log($this->attachment_size, 1024)) : 0;
	        $power = min($power, count($units) - 1); // Prevent overflow
	        $value = $this->attachment_size / pow(1024, $power);
	        $attachment_size = round($value, $precision) . ' ' . $units[$power];
	    }else{
	    	$attachment_size = null;
	    }

	    if($this->attachment_date){
	    	$attachment_date = Carbon::parse($this->attachment_date)->format('M d, Y');
	    }else{
	    	$attachment_date = null;
	    }

        $extension = pathinfo($this->attachment_name, PATHINFO_EXTENSION);

        $attachment_icon = match (strtolower($extension)) {
            'pdf' => 'bi bi-file-earmark-pdf', 
            'doc', 'docx' => 'bi bi-file-earmark-word', 
            'xls', 'xlsx' => 'bi bi-file-earmark-spreadsheet', 
            'jpg', 'jpeg', 'png', 'gif' => 'bi bi-file-earmark-image', 
            'zip', 'rar' => 'bi bi-file-earmark-zip', 
            'txt' => 'bi bi-file-earmark-text', 
            default => 'bi bi-file-earmark', 
        };

        return [
            "state_attachment_id" => $this->state_attachment_id,
            "state_tender_id" => $this->state_tender_id,
            "attachment_name" => $this->attachment_name,
            "attachment_size" => $attachment_size,
            "attachment_date" => $attachment_date,
            "attachment_url" => $this->attachment_url,
            "attachment_icon" => $attachment_icon
        ];
    }
}
