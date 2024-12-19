<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternationalAttachment extends Model
{
    use HasFactory;
    protected $fillable = [
    	'international_tender_id',
    	'attachment_name',
    	'attachment_size',
    	'attachment_date',
    	'attachment_url',
        'attachment_s3_url'
    ];

    protected $primaryKey = 'international_attachment_id';

    public function InternationalTender()
    {
        return $this->belongsTo('App\Models\InternationalTender','international_tender_id','international_tender_id');
    }
}
