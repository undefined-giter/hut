<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $phone;
    public $message;

    /**
     * Créer une nouvelle instance du message.
     *
     * @param string $name
     * @param string $email
     * @param string $message
     */
    public function __construct(string $name, ?string $email, ?string $phone, string $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->message = $message;
    }

    /**
     * Obtenir l'enveloppe du message.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Cabane - ' . $this->name,
            from: new Address('leo.ripert@gmail.com', 'Cabane - Châtel-En-Trièves / Cordéac')
        );
    }

    /**
     * Obtenir la définition du contenu du message.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
            with: [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'messageContent' => $this->message,
            ]
        );
    }

    /**
     * Obtenir les pièces jointes du message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}
