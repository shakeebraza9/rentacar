<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignupEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer_name;
    public $company_name;
    public $username;
    public $email;
    public $verification_link;

    /**
     * Create a new message instance.
     *
     * @param $customer_name
     * @param $company_name
     * @param $username
     * @param $email
     * @param $verification_link
     */
    public function __construct($customer_name, $company_name, $username, $email, $verification_link)
    {
        $this->customer_name = $customer_name;
        $this->company_name = $company_name;
        $this->username = $username;
        $this->email = $email;
        $this->verification_link = $verification_link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.signup') // View with the HTML template
                    ->with([
                        'customer_name' => $this->customer_name,
                        'company_name' => $this->company_name,
                        'username' => $this->username,
                        'email' => $this->email,
                        'verification_link' => $this->verification_link,
                    ]);
    }
}
