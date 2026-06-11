<?php

namespace App\Observers;

use App\Mail\NewOrderPlacedMail;
use App\Models\Invoice;
use App\Services\InvoiceCopyMailService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InvoiceObserver
{
    public function created(Invoice $invoice): void
    {
        if ($invoice->status === 'paid') {
            $this->onPaid($invoice);
        }
    }

    public function updated(Invoice $invoice): void
    {
        if ($invoice->status === 'paid' && $invoice->wasChanged('status')) {
            $this->onPaid($invoice);
        }
    }

    private function onPaid(Invoice $invoice): void
    {
        $order = $invoice->order;
        if (!$order) {
            return;
        }

        $escaperoom = $order->escaperoom;
        if (!$escaperoom) {
            return;
        }

        app(InvoiceCopyMailService::class)->send($escaperoom, $invoice->invoice_number, $invoice->pdf_url);

        $this->notifyNewOrder($invoice, $order, $escaperoom);
    }

    private function notifyNewOrder(Invoice $invoice, $order, $escaperoom): void
    {
        if (!($escaperoom->escaperoomSetting->notify_new_order ?? true)) {
            return;
        }

        $recipient = $escaperoom->invoice_email ?: $escaperoom->email;
        if (!$recipient) {
            return;
        }

        try {
            Mail::to($recipient)->send(new NewOrderPlacedMail($order, $escaperoom, $invoice));
        } catch (\Exception $e) {
            Log::error('Kon nieuwe-bestelling-mail niet versturen voor invoice ' . $invoice->id . ': ' . $e->getMessage());
        }
    }
}
