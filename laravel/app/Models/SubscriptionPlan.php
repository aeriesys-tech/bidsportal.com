<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan', 
        'price', 
        'days', 
        'month',
        'description', 
        'discount' 
    ];

    protected $primaryKey = 'subscription_plan_id';
}
