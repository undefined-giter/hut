<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use Illuminate\Support\Collection;

class UserDeletedNotification extends Notification
{
    use Queueable;

    protected $user;
    protected $reservations;

    public function __construct(User $user, Collection $reservations)
    {
        $this->user = $user;
        $this->reservations = $reservations;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $adminEmail = config('admin.email');
        $adminPhoneHref = config('admin.phone');
        $adminPhone = format_phone_number($adminPhoneHref);

        return (new MailMessage)
            ->subject("Cabane - {$this->user->name} -> compte et réservation supprimés")
            ->view('emails.userDeleted', [
                'user' => $this->user,
                'reservations' => $this->reservations,

                'adminEmail' => $adminEmail,
                'adminPhoneHref' => $adminPhoneHref,
                'adminPhone' => $adminPhone,
            ]);
    }
}
