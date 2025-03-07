<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $ticket;
    public $attraction;
    public $addons;

    public function __construct($order, $ticket, $attraction, $addons)
    {
        $this->order = $order;
        $this->ticket = $ticket;
        $this->attraction = $attraction;
        $this->addons = $addons;
    }

    public function build()
    {
        return $this->subject('Your Order Confirmation - #' . $this->order->id)
                    ->view('emails.order_confirmation')
                    ->with([
                        'order' => $this->order,
                        'ticket' => $this->ticket,
                        'attraction' => $this->attraction,
                        'addons' => $this->addons
                    ]);
    }
}