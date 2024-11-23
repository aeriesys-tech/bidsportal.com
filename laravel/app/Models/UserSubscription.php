<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;
    protected $fillable = [
		'user_id',
		'order_id', 
		'payment_method', 
		'active_status', 
        'validity', 
        'valid_from',
        'valid_to',
		'item_number',
		'txn_id',
		'ipn_track_id',
        'payment_gross',
		'currency_code',
        'subscription_plan_id',
		'payer_email',
		'payment_status',
		'subscr_month',
		'payment_date',
        'created_date'
    ];

    protected $primaryKey = 'user_subscription_id';
}
