<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalTenderLog extends Model
{
	use HasFactory;

    protected $fillable = [
    	'notice_id',
        'tender_no',
        'error',
        'tender_link',
        'posted_date'
    ];

    protected $primaryKey = 'federal_tender_log_id';
}
