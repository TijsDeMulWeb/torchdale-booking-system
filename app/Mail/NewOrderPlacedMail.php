<?php

namespace App\Mail;

use App\Models\Escaperoom;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class NewOrderPlacedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order,
        public Escaperoom $escaperoom,
        public Invoice $invoice,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('info@torchdaleplanner.be', $this->escaperoom->name),
            subject: 'Nieuwe bestelling — ' . $this->escaperoom->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.newOrderPlaced',
            with: [
                'order'      => $this->order,
                'escaperoom' => $this->escaperoom,
                'invoice'    => $this->invoice,
            ],
        );
    }

    public function attachments(): array
    {
        if (!$this->invoice->pdf_url || !Storage::disk('local')->exists($this->invoice->pdf_url)) {
            return [];
        }

        return [
            Attachment::fromStorageDisk('local', $this->invoice->pdf_url)
                ->as('factuur-' . $this->invoice->invoice_number . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
