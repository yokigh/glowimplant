<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetUrl;
    public $lang;

    public function __construct($resetUrl, $lang)
    {
        $this->resetUrl = $resetUrl;
        $this->lang = $lang;
    }

    public function build()
    {
        return $this->subject(__('emails.password_reset_subject'))
                    ->view('emails.reset-password')  // تعيين القالب الخاص بنا
                    ->with([
                        'resetUrl' => $this->resetUrl,
                        'lang' => $this->lang,
                    ]);
    }
}
