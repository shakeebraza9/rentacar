<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExtraPaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pickupDate;

    public function __construct($pickupDate)
    {
        $this->pickupDate = $pickupDate;
    }

    public function build()
    {
        return $this->subject('Extra Payment Request')
                    ->view('emails.extra_payment')
                    ->with(['pickupDate' => $this->pickupDate]);
    }
}