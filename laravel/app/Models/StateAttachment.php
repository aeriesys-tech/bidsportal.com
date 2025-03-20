<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateAttachment extends Model
{
    use HasFactory;
    protected $fillable = [
		'state_tender_id',
		'attachment_name',
		'attachment_size',
		'attachment_date',
		'attachment_url'
    ];

    protected $primaryKey = 'state_attachment_id';

    public function StateTender()
    {
        return $this->hasOne('App\Models\StateTender','state_tender_id','state_tender_id');
    }
}
