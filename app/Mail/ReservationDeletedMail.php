<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationDeletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $userName;
    public $name2;
    public $email;
    public $phone;
    public $isAdmin;

    /**
     * Create a new message instance.
     *
     * @param $reservation, $userName, $name2, $email, $isAdmin
     */
    public function __construct($reservation, $userName, $name2, $email, $phone, $isAdmin)
    {
        $this->reservation = $reservation;
        $this->userName = $userName;
        $this->name2 = $name2;
        $this->email = $email;
        $this->phone = $phone;
        $this->isAdmin = $isAdmin;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Réservation Annulée',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation_deleted', // Utilise la vue pour l'email de suppression
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
