<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'txn_id',
        'user_id',
        'order_id',
        'payment_amount',
        'payment_status',
        'first_name',
        'last_name',
        'business',
        'payer_email',
        'payer_id',
        'receiver_email',
        'receiver_id',
        'item_name',
        'item_number',
        'payment_date',
        'payment_gross',
        'payment_fee',
        'mc_currency',
        'createdtime'
    ];

    protected $primaryKey = 'user_payment_id';

    public function PurchaseItems(){
        return $this->hasMany('App\Models\PurchaseItem', 'user_payment_id', 'user_payment_id');
    }
}
