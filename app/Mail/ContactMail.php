<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $name;
    public string $email;
    public ?string $phone;
    public string $messageContent;

    public string $adminEmail;
    public ?string $adminPhoneHref;
    public ?string $adminPhone;

    /**
     * Create a new message instance.
     *
     * @param string $name
     * @param string $email
     * @param string $messageContent
     * @param string $adminEmail
     * @param string|null $adminPhoneHref
     * @param string|null $adminPhone
     */
    public function __construct(string $name, string $email, ?string $phone, string $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->messageContent = $message;

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
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
            // with: [
            //     'name' => $this->name,
            //     'email' => $this->email,
            //     'phone' => $this->phone,
            //     'messageContent' => $this->message,
            //     'adminPhone' => $this->adminPhone,
            // ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}
