<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterMail;

class SendNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $subject, $description, $emails;

    public function __construct($subject, $description, $emails)
    {
        $this->subject = $subject;
        $this->description = $description;
        $this->emails = $emails;
    }

    public function handle()
    {
        foreach ($this->emails as $email) {
            Mail::to($email)->send(new NewsletterMail($this->subject, $this->description));
        }
    }
}
