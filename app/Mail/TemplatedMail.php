<?php

namespace App\Mail;

use App\Models\MailTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TemplatedMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $renderedSubject;
    private string $renderedBody;
    private array $templateAttachments;
    private ?string $fromName;
    private ?string $replyToEmail;

    /**
     * @param array<int, array{data: string, filename: string, mime: string}> $attachments
     */
    public function __construct(MailTemplate $template, array $variables = [], array $attachments = [], ?string $fromName = null, ?string $replyToEmail = null)
    {
        $this->renderedSubject     = $template->renderSubject($variables);
        $this->renderedBody        = $template->render($variables);
        $this->templateAttachments = $attachments;
        $this->fromName            = $fromName;
        $this->replyToEmail        = $replyToEmail;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: $this->fromName ? new Address(config('mail.from.address'), $this->fromName) : null,
            replyTo: $this->replyToEmail ? [new Address($this->replyToEmail, $this->fromName)] : [],
            subject: $this->renderedSubject,
        );
    }

    public function content(): Content
    {
        return new Content(view: 'mails.templated', with: ['body' => $this->renderedBody]);
    }

    public function attachments(): array
    {
        return array_map(
            fn (array $attachment) => Attachment::fromData(fn () => $attachment['data'], $attachment['filename'])
                ->withMime($attachment['mime']),
            $this->templateAttachments
        );
    }
}
