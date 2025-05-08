<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPassword extends Notification
{
    public $token;
    public $lang;

    public function __construct($token, $lang)
    {
        $this->token = $token;
        $this->lang = $lang;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $resetUrl = route('password.reset', ['lang' => $this->lang, 'token' => $this->token]);

        return (new MailMessage)
            ->subject(__('إعادة تعيين كلمة المرور'))
            ->line(__('لقد تلقيت هذا البريد لأنك طلبت إعادة تعيين كلمة المرور.'))
            ->action(__('إعادة تعيين كلمة المرور'), $resetUrl)
            ->line(__('إذا لم تطلب إعادة تعيين كلمة المرور، فلا داعي لاتخاذ أي إجراء.'));
    }
}
