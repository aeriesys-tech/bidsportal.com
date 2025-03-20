<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrivateAttachment extends Model
{
    use HasFactory;
    protected $fillable = [
    	'private_tender_id',
    	'attachment_name',
    	'attachment_size',
    	'attachment_date',
    	'attachment_url',
        'attachment_s3_url'
    ];

    protected $primaryKey = 'private_attachment_id';

    public function PrivateTender()
    {
        return $this->belongsTo('App\Models\PrivateTender','private_tender_id','private_tender_id');
    }
}
