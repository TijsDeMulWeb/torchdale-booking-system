<?php

namespace App\Mail;

use App\Models\MailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TemplatedMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $renderedSubject;
    private string $renderedBody;

    public function __construct(MailTemplate $template, array $variables = [])
    {
        $this->renderedSubject = $template->renderSubject($variables);
        $this->renderedBody    = $template->render($variables);
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->renderedSubject);
    }

    public function content(): Content
    {
        return new Content(view: 'mails.templated', with: ['body' => $this->renderedBody]);
    }

    public function attachments(): array
    {
        return [];
    }
}
