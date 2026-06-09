<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ShowOrderInvoiceController extends Controller
{
    public function __invoke(Order $order): StreamedResponse
    {
        $invoice = $order->invoice;

        abort_if(!$invoice || !$invoice->pdf_url, 404);
        abort_if(!Storage::disk('local')->exists($invoice->pdf_url), 404);

        return Storage::disk('local')->response(
            $invoice->pdf_url,
            $invoice->invoice_number . '.pdf',
            ['Content-Type' => 'application/pdf'],
        );
    }
}
