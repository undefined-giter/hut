<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class ContactAutoResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public ?string $name;
    public string $adminEmail;
    public ?string $adminPhoneHref;
    public ?string $adminPhone;

    /**
     * Constructor with typed properties allowing $name to be null.
     *
     * @param string|null $name
     */
    public function __construct(?string $name)
    {
        $this->name = $name;

        $this->adminEmail = config('admin.email');
        $this->adminPhoneHref = config('admin.phone');
        $this->adminPhone = format_phone_number($this->adminPhoneHref);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Cabane - ' . $this->name,
            from: new Address($this->adminEmail, 'Cabane'),
            replyTo: [new Address($this->adminEmail, 'Cabane')]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contactAutoResponseMail',
            with: [
                'name' => $this->name,
                'adminEmail' => $this->adminEmail,
                'adminPhone' => $this->adminPhone,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
