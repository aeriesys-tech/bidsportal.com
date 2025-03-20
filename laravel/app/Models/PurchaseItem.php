<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_payment_id',
        'federal_tender_id',
        'state_tender_id'
    ];

    protected $primaryKey = 'purhase_item_id';

    public function FederalTender(){
        return $this->belongsTo('App\Models\FederalTender', 'federal_tender_id', 'federal_tender_id');
    }

    public function StateTender(){
        return $this->belongsTo('App\Models\StateTender', 'state_tender_id', 'state_tender_id');
    }
}
