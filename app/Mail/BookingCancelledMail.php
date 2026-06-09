<?php

namespace App\Mail;

use App\Models\Escaperoom;
use App\Models\GiftVoucher;
use App\Models\Order;
use App\Models\TimeSlot;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingCancelledMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public TimeSlot $timeSlot,
        public Order $order,
        public Escaperoom $escaperoom,
        public ?GiftVoucher $voucher = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('info@torchdaleplanner.be', $this->escaperoom->name),
            subject: 'Je boeking bij ' . $this->escaperoom->name . ' is geannuleerd',
        );
    }

    public function content(): Content
    {
        $customerName = trim(
            ($this->order->customer?->first_name ?? $this->order->customer_first_name ?? '')
            . ' '
            . ($this->order->customer?->last_name ?? $this->order->customer_last_name ?? '')
        ) ?: 'klant';

        return new Content(
            view: 'mails.bookingCancelled',
            with: [
                'timeSlot'     => $this->timeSlot,
                'order'        => $this->order,
                'escaperoom'   => $this->escaperoom,
                'voucher'      => $this->voucher,
                'customerName' => $customerName,
            ],
        );
    }
}
