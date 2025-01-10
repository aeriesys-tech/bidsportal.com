<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $user;
    public $subscription;

    public function __construct($user, $subscription)
    {
        $this->user = $user;
        $this->subscription = $subscription;
    }

    public function build()
    {
        $user = $this->user;
        $subscription = $this->subscription;


        $name = $user->name;
        $amt = $subscription['amt'];
        $plan = $subscription['plan'];
        $order_id = $subscription['order_id'];
        $txn_id = $subscription['txn_id'];
        $payment_type = 'Online';
        $tran_date = $subscription['tran_date'];
        $tran_time = $subscription['tran_time'];
        $subtotal = $subscription['subtotal'];
        $discount = $subscription['discount'];
        $total = $subscription['total'];
        $BASE_URL = config('app.url');

        $images = ([
            'logo' => config('app.url').'images/logo.png',
            'share' => config('app.url').'images/share.png',
            'location' => config('app.url').'images/location.png',
            'category' => config('app.url').'images/category.png',
            'facebook' => config('app.url').'images/facebook.png',
            'linkdein' => config('app.url').'images/linkdein.png',
            'twitter' => config('app.url').'images/twitter.png',
            'mail' => config('app.url').'images/mail.jpg',
            'mail_png' => config('app.url').'images/mail.png',
            'phone' => config('app.url').'images/phone.png'
        ]);


        return $this->view('emails.SubscriptionMail', compact('name', 'amt', 'plan', 'order_id', 'txn_id', 'payment_type', 'tran_date',  'tran_time', 'subtotal', 'discount', 'total', 'BASE_URL', 'images'))
        ->cc('support@bidsportal.com')
        ->subject('BidsPortal::Payment Successful');
    }
}
