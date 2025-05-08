<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $description;

    public function __construct($subject, $description)
    {
        $this->subject = $subject;
        $this->description = $description;
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.newsletter')
                    ->with([
                        'description' => $this->description,
                    ]);
    }
}
