<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OnBoardMail extends Mailable implements ShouldQueue
{
    public $details;
    use Queueable, SerializesModels;
    
    public function __construct($details)
    {
        //
        $this->details=$details;
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
