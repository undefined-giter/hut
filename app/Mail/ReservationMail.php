<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;

class ReservationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $action;
    public $options;
    public $isAdmin;

    /**
     * Create a new message instance.
     *
     * @param $reservation
     * @param $action
     * @param $options
     * @param bool $isAdmin
     */
    public function __construct($reservation, $action, $options, $isAdmin = false)
    {
        $this->reservation = $reservation;
        $this->action = $action;
        $this->options = $options;
        $this->isAdmin = $isAdmin;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Demande de réservation ' . ($this->action === 'created' ? 'réalisée' : 'mise à jour'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation', // Assure-toi de créer cette vue
            with: [
                'reservation' => $this->reservation,
                'action' => $this->action,
                'options' => $this->options,
                'isAdmin' => $this->isAdmin,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath(public_path('img/hut.png'))
                // ->as('reservation-image.jpg') // Nom de l'image jointe renommée
                ->withMime('image/png') // Type MIME de l'image
        ];
    }
}
