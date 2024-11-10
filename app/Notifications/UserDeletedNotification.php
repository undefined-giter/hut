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

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user, Collection $reservations)
    {
        $this->user = $user;
        $this->reservations = $reservations;
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
        $message = (new MailMessage)
            ->view('emails.userDeleted', [
            ->subject('Suppression de compte utilisateur')
            ->greeting("Bonjour,")
            ->line("L'utilisateur {$this->user->name} ({$this->user->email}) a supprimé son compte.")
            ->line("Voici la liste de ses réservations actuelles et futures :")
        ])

        foreach ($this->reservations as $reservation) {
            $message->line("Réservation du {$reservation->start_date->format('d/m/Y')} au {$reservation->end_date->format('d/m/Y')}, pour {$reservation->nights} nuit(s).");
        }

        $message->line('Cordialement,');
        
        return $message;
    }
}
