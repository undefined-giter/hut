<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AutoResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $adminEmail;

    public function __construct(string $name, string $adminEmail)
    {
        $this->name = $name;
        $this->adminEmail = $adminEmail;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Merci pour votre message !',
            from: new \Illuminate\Mail\Mailables\Address('leo.ripert@gmail.com', 'Cabane - administrateurs')
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.AutoResponseMail',
            with: [
                'name' => $this->name,
                'adminEmail' => $this->adminEmail
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
