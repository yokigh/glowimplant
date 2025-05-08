<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;

    /**
     * إنشاء البريد الإلكتروني مع البيانات
     */
    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    /**
     * بناء البريد الإلكتروني
     */
    public function build()
    {
        return $this->subject('Payment Successful')
                    ->view('emails.payment')
                    ->with([
                        'payment' => $this->payment,
                    ]);
    }
}
