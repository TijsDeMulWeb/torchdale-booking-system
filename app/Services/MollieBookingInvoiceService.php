<?php

namespace App\Services;

use App\Models\Order;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\Log;
use Mollie\Api\MollieApiClient;
use Mollie\Api\Http\Data\DataCollection;
use Mollie\Api\Http\Data\InvoiceLine;
use Mollie\Api\Http\Data\Money;
use Mollie\Api\Http\Data\Recipient;
use Mollie\Api\Http\Requests\CreateSalesInvoiceRequest;
use Mollie\Api\Types\RecipientType;
use Mollie\Api\Types\SalesInvoiceStatus;
use Mollie\Api\Types\VatMode;
use Mollie\Api\Types\VatScheme;

class MollieBookingInvoiceService
{
    /**
     * Send a Mollie ISSUED sales invoice (betaallink) for a manual booking.
     * Stores mollie_id + invoice_number on the order — no Invoice record yet.
     * The Invoice record is only created by the webhook once payment is confirmed.
     * Returns true on success, false on failure.
     */
    public function send(Order $order, TimeSlot $timeSlot, string $mollieApiKey): bool
    {
        $customer = $order->customer;

        if (!$customer) {
            Log::warning('MollieBookingInvoiceService: no customer on order ' . $order->id);
            return false;
        }

        // Already sent
        if ($order->mollie_id) {
            return true;
        }

        try {
            /** @var \Mollie\Api\MollieApiClient $mollie */
            $street = trim(($customer->street ?? '') . ' ' . ($customer->house_number ?? ''));

            $recipient = new Recipient(
                type: RecipientType::CONSUMER,
                email: $customer->email,
                streetAndNumber: $street ?: null,
                postalCode: $customer->postal_code ?: null,
                city: $customer->city ?: null,
                country: 'BE',
                locale: 'nl_BE',
                givenName: $customer->first_name,
                familyName: $customer->last_name,
                phone: $customer->phone ?: null,
            );

            $orderedItem = $timeSlot->orderedItems()->first();
            $vatRate     = number_format((float) ($orderedItem?->vat_percentage ?? 6), 2, '.', '');

            $description = $timeSlot->room->name
                . ' – ' . $timeSlot->start_time->format('d/m/Y')
                . ' ' . $timeSlot->start_time->format('H:i')
                . '–' . $timeSlot->end_time->format('H:i');

            if ($timeSlot->language) {
                $description .= ' (' . $timeSlot->language->name . ')';
            }

            $lines = [
                new InvoiceLine(
                    description: $description,
                    quantity: 1,
                    vatRate: $vatRate,
                    unitPrice: new Money('EUR', number_format((float) $order->total, 2, '.', '')),
                ),
            ];

            // Always ISSUED first — customer gets a payment link email.
            // After payment, Mollie fires a webhook and we mark the invoice as paid.
            $request = new CreateSalesInvoiceRequest(
                currency: 'EUR',
                status: SalesInvoiceStatus::ISSUED,
                vatScheme: VatScheme::STANDARD,
                vatMode: VatMode::INCLUSIVE,
                paymentTerm: '30 days',
                recipientIdentifier: $customer->email,
                recipient: $recipient,
                lines: new DataCollection($lines),
                webhookUrl: route('webhook.mollie'),
                isEInvoice: false,
            );

            $mollie = new MollieApiClient();
            $mollie->setApiKey($mollieApiKey);

            $mollieInvoice = $mollie->send($request);

            $invoiceNumber = $mollieInvoice->invoiceNumber ?? ('INV-' . $order->id . '-' . time());

            // Only store the Mollie reference on the order — NO Invoice record yet.
            // The Invoice (receipt) is created by the webhook once the customer has actually paid.
            $order->mollie_id      = $mollieInvoice->id;
            $order->invoice_number = $invoiceNumber;
            $order->save();

            return true;

        } catch (\Exception $e) {
            Log::error('MollieBookingInvoiceService failed for order ' . $order->id . ': ' . $e->getMessage());
            return false;
        }
    }
}
