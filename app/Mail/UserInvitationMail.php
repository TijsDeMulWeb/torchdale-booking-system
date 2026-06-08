<?php

namespace App\Mail;

use App\Models\Escaperoom;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class UserInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public User $user, public Escaperoom $escaperoom, public string $passwordSetupUrl)
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
            subject: 'Welkom bij Torchdale Planner — stel je wachtwoord in',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.userInvitation',
            with: [
                'user' => $this->user,
                'escaperoom' => $this->escaperoom,
                'passwordSetupUrl' => $this->passwordSetupUrl,
            ],
        );
    }
}
