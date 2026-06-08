<?php

namespace App\Mail;

use App\Models\Escaperoom;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class EscaperoomRequestAcceptedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Escaperoom $escaperoom, public string $publicKey)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('info@torchdaleplanner.be', 'Torchdaleplanner'),
            subject: 'Welkom bij Torchdaleplanner — je account is goedgekeurd',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.escaperoomRequestAccepted',
            with: [
                'escaperoom' => $this->escaperoom,
                'accountSetupUrl' => route('accountSetup.show', ['key' => $this->publicKey]),
            ],
        );
    }
}
