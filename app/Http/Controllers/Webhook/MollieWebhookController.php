<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Mollie\Api\MollieApiClient;

class MollieWebhookController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $mollieInvoiceId = $request->input('id');

        if (!$mollieInvoiceId) {
            return response('', 200);
        }

        $order = Order::where('mollie_id', $mollieInvoiceId)->first();

        if (!$order) {
            Log::warning('Mollie webhook: no order found for invoice ' . $mollieInvoiceId);
            return response('', 200);
        }

        try {
            $mollieKey = $order->escaperoom->escaperoomSetting->mollie_api_key
                ?? env('MOLLIE_KEY');

            $mollie = new MollieApiClient();
            $mollie->setApiKey($mollieKey);

            $mollieInvoice = $mollie->salesInvoices->get($mollieInvoiceId);

            if ($mollieInvoice->status !== 'paid') {
                return response('', 200);
            }

            // Voorkom dubbele verwerking
            $alreadyProcessed = DB::table('invoices')
                ->where('mollie_invoice_id', $mollieInvoiceId)
                ->exists();

            if ($alreadyProcessed) {
                return response('', 200);
            }

            $invoiceNumber = $mollieInvoice->invoiceNumber ?? ('INV-' . $order->id . '-' . time());

            // PDF downloaden
            $pdfPath = null;
            $mollieHref = $mollieInvoice->_links->pdfLink->href ?? null;
            if ($mollieHref) {
                $pdfResponse = Http::withToken($mollieKey)->get($mollieHref);
                if ($pdfResponse->successful()) {
                    $pdfPath = 'escaperooms/' . $order->escaperoom_id . '/invoices/' . $invoiceNumber . '.pdf';
                    Storage::disk('local')->put($pdfPath, $pdfResponse->body());
                }
            }

            DB::table('invoices')->insert([
                'customer_id'       => $order->customer_id,
                'order_id'          => $order->id,
                'mollie_invoice_id' => $mollieInvoiceId,
                'pdf_url'           => $pdfPath,
                'source'            => 'mollie',
                'invoice_number'    => $invoiceNumber,
                'status'            => 'paid',
                'amount'            => $order->total,
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);

            $order->status         = 'paid';
            $order->invoice_number = $invoiceNumber;
            $order->save();

        } catch (\Exception $e) {
            Log::error('Mollie webhook verwerking mislukt voor invoice ' . $mollieInvoiceId . ': ' . $e->getMessage());
        }

        return response('', 200);
    }
}
