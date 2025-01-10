<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FederalTenderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $bids;
    public $user;
    public $request;

    public function __construct($bids, $user, $request)
    {
        $this->bids = $bids;
        $this->user = $user;
        $this->request = $request;
    }

    public function build()
    {
        $user = $this->user;
        $bids = $this->bids;
        $request = $this->request;
        $app_url = config('app.url');
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


        return $this->view('emails.FederalTender', compact('bids','user','request', 'images', 'app_url'))
        ->cc('support@bidsportal.com')
        ->subject('BidsPortal :: '.$request->subject);
    }
}
