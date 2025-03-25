<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'position',
        'company_name',
        'phone',
        'web_address',
        'mailing_address',
        'city',
        'state',
        'pin_code',
        'status',
        'pw',
        'forgot_pass_identity',
        'email_verified_at'
    ];

    protected $primaryKey = 'user_id';
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Automatically hash the password when set.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = \Hash::make($value);
    }

    
    public function UserSubscription()
    {
        return $this->hasOne('App\Models\UserSubscription', 'user_id', 'user_id')->latest('user_subscription_id');
    }

    public function UserSetAsides()
    {
        return $this->hasMany('App\Models\UserSetAside', 'user_id', 'user_id');
    }
}
