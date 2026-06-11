<?php

namespace App\Mail;

use App\Models\Escaperoom;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class InvoiceCopyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Escaperoom $escaperoom,
        public string $invoiceNumber,
        public ?string $pdfPath,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('info@torchdaleplanner.be', $this->escaperoom->name),
            subject: 'Factuur ' . $this->invoiceNumber . ' — ' . $this->escaperoom->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.invoiceCopy',
            with: [
                'escaperoom'    => $this->escaperoom,
                'invoiceNumber' => $this->invoiceNumber,
            ],
        );
    }

    public function attachments(): array
    {
        if (!$this->pdfPath || !Storage::disk('local')->exists($this->pdfPath)) {
            return [];
        }

        return [
            Attachment::fromStorageDisk('local', $this->pdfPath)
                ->as('factuur-' . $this->invoiceNumber . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
