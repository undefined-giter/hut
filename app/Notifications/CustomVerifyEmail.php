<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;

class CustomVerifyEmail extends BaseVerifyEmail
{
    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        $adminEmail = config('admin.email');
        $adminPhoneHref = config('admin.phone');
        $adminPhone = format_phone_number($adminPhoneHref);

        return (new MailMessage)
            ->view('emails.verify', [
                'verificationUrl' => $verificationUrl,
                'adminEmail' => $adminEmail,
                'adminPhoneHref' => $adminPhoneHref,
                'adminPhone' => $adminPhone,
            ])
            ->subject('Merci de vérifier votre adresse email');
    }
}
