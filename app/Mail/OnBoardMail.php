<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OnBoardMail extends Mailable
{
    var $detail;
    use Queueable, SerializesModels;
    
    public function __construct($details)
    {
        //
        $detail=$details;
        // print_r(gettype($detail));

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Congratulations on onboarding with us!')
                    ->view('emails.welcome');
    }
}
