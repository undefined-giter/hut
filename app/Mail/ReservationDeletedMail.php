<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class ReservationDeletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public ?string $userName;
    public ?string $name2;
    public ?string $email;
    public ?string $phone;
    public ?int $userId;
    public bool $isAdmin;
    public string $adminEmail;
    public ?string $adminPhone;

    /**
     * Create a new message instance.
     *
     * @param mixed $reservation
     * @param string|null $userName
     * @param string|null $name2
     * @param string $email
     * @param string|null $phone
     * @param bool $isAdmin
     */
    public function __construct($reservation, ?string $userName, ?string $name2, string $email, ?string $phone, ?int $userId = null, bool $isAdmin)
    {
        $this->reservation = $reservation;
        $this->userName = $userName;
        $this->name2 = $name2;
        $this->email = $email;
        $this->phone = $phone;
        $this->userId = $userId;
        $this->isAdmin = $isAdmin;
        
        $this->adminEmail = config('admin.email');
        $this->adminPhone = format_phone_number(config('admin.phone'));
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $toEmail = $this->isAdmin ? $this->adminEmail : $this->email;

        return new Envelope(
            subject: 'Réservation Annulée',
            from: new Address($this->adminEmail, 'Cabane'),
            to: [new Address($toEmail, $this->isAdmin ? 'Admin' : $this->userName)],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation_deleted',
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
