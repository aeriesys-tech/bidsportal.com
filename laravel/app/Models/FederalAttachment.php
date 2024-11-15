<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalAttachment extends Model
{
    use HasFactory;
    protected $fillable = [
    	'federal_tender_id',
    	'attachment_name',
    	'attachment_size',
    	'attachment_date',
    	'attachment_url'
    ];

    protected $primaryKey = 'federal_attachment_id';

    public function FederalTender()
    {
        return $this->belongsTo('App\Models\FederalTender','federal_tender_id','federal_tender_id');
    }

}
