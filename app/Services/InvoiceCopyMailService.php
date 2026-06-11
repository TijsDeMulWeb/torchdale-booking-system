<?php

namespace App\Services;

use App\Mail\InvoiceCopyMail;
use App\Models\Escaperoom;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InvoiceCopyMailService
{
    /**
     * Stuur een kopie van de factuur-PDF naar het facturatie-emailadres van het escaperoom
     * (of het algemene e-mailadres als dat niet is ingesteld).
     */
    public function send(Escaperoom $escaperoom, string $invoiceNumber, ?string $pdfPath): void
    {
        $recipient = $escaperoom->invoice_email ?: $escaperoom->email;
        if (!$recipient) {
            return;
        }

        try {
            Mail::to($recipient)->send(new InvoiceCopyMail($escaperoom, $invoiceNumber, $pdfPath));
        } catch (\Exception $e) {
            Log::error('Kon factuurkopie niet versturen voor factuur ' . $invoiceNumber . ': ' . $e->getMessage());
        }
    }
}
