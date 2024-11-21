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
    public ?string $userName;
    public ?string $name2;
    public ?string $phone;
    public ?string $email;
    public ?int $userId;
    public string $action;
    public $options;
    public bool $isAdmin;
    public string $adminEmail;
    public ?string $adminPhoneHref;
    public ?string $adminPhone;

    /**
     * Create a new message instance.
     *
     * @param mixed $reservation
     * @param string|null $userName
     * @param string|null $name2
     * @param string|null $phone
     * @param string $email
     * @param int|null $userId
     * @param string $action
     * @param mixed $options
     * @param bool $isAdmin
     * @param bool $adminEmail
     * @param string|null $adminPhoneHref
     * @param string|null $adminPhone
     */
    public function __construct($reservation, ?string $userName = null, ?string $name2 = null, ?string $phone = null, string $email, ?int $userId = null, string $action, $options, bool $isAdmin = false)
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

        $this->adminEmail = config('admin.email');
        $this->adminPhoneHref = config('admin.phone');
        $this->adminPhone = format_phone_number($this->adminPhoneHref);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $emailTo = $this->isAdmin ? $this->adminEmail : $this->email;

        if (!$emailTo) {
            throw new \Exception("L'adresse email est manquante.");
        }

        return new Envelope(
            subject: 'Cabane - Demande de réservation ' . 
                ($this->action === 'created' ? 'réalisée' : 
                ($this->action === 'updated_options' ? 'options mises à jour' : 'date et options mises à jour')),
                to: [$emailTo],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation',
            // with: [
            //     'reservation' => $this->reservation,
            //     'userName' => $this->userName,
            //     'name2' => $this->name2,
            //     'phone' => $this->phone,
            //     'email' => $this->email,
            //     'userId' => $this->userId,
            //     'action' => $this->action,
            //     'options' => $this->options,
            //     'isAdmin' => $this->isAdmin,
            //     'adminEmail' => $this->adminEmail,
            //     'adminPhone' => $this->adminPhone,
            // ]
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
            // Attachment::fromPath(public_path('img/hut.png'))
            //     ->withMime('image/png') // Type MIME de l'image
        ];
    }
}
