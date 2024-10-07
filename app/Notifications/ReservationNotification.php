<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationNotification extends Notification
{
    use Queueable;

    protected $reservation;
    protected $action;

    /**
     * Create a new notification instance.
     *
     * @param $reservation
     * @param $action
     */
    public function __construct($reservation, $action)
    {
        $this->reservation = $reservation;
        $this->action = $action; // 'created' ou 'updated'
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Réservation ' . ($this->action === 'created' ? 'créée' : 'mise à jour'))
            ->view('emails.reservation', [
                'reservation' => $this->reservation,
                'action' => $this->action,
            ]);
    }
}
