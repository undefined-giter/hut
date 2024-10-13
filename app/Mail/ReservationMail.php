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
    public $userName;
    public $name2;
    public $phone;
    public $email;
    public $userId;
    public $action;
    public $options;
    public $isAdmin;

    /**
     * Create a new message instance.
     *
     * @param $reservation
     * @param $userName
     * @param $name2
     * @param $phone
     * @param $email
     * @param $userId
     * @param $action
     * @param $options
     * @param bool $isAdmin
     */
    public function __construct($reservation, $userName, $name2 = null, $phone = null, $email = null, $userId = null, $action, $options, $isAdmin = false)
    {
        $this->reservation = $reservation;
        $this->userName = $userName;
        $this->name2 = $name2;
        $this->phone = $phone;
        $this->email = $email;
        $this->userId = $userId;
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
            subject: 'Demande de réservation ' . 
                ($this->action === 'created' ? 'réalisée' : 
                ($this->action === 'updated_options' ? 'options mises à jour' : 'date et options mises à jour')),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation', // vue correspondante
            with: [
                'reservation' => $this->reservation,
                'userName' => $this->userName,
                'name2' => $this->name2,
                'phone' => $this->phone,
                'email' => $this->email,
                'userId' => $this->userId,
                'action' => $this->action,
                'options' => $this->options,
                'isAdmin' => $this->isAdmin,
            ]
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
