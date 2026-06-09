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
            $street  = trim(($customer->street ?? '') . ' ' . ($customer->house_number ?? ''));
            $locale  = $this->resolveLocale($timeSlot->language?->name);
            $country = $customer->country ?: 'BE';

            $recipient = new Recipient(
                type: RecipientType::CONSUMER,
                email: $customer->email,
                streetAndNumber: $street ?: null,
                postalCode: $customer->postal_code ?: null,
                city: $customer->city ?: null,
                country: $country,
                locale: $locale,
                givenName: $customer->first_name,
                familyName: $customer->last_name,
                phone: $customer->phone ?: null,
            );

            $orderedItem = $timeSlot->orderedItems()->first();
            $vatRate     = number_format((float) ($orderedItem?->vat_percentage ?? 6), 2, '.', '');

            $description = $this->buildDescription($timeSlot, $locale);
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

    // Exhaustive list of locales Mollie actually supports for hosted pages + customer emails.
    // Any locale not in this set falls back to nl_BE.
    private const MOLLIE_LOCALES = [
        'nl_NL', 'nl_BE',
        'en_US', 'en_GB',
        'de_DE', 'de_AT', 'de_CH', 'de_LU',
        'fr_FR', 'fr_BE', 'fr_LU',
        'es_ES', 'ca_ES',
        'it_IT',
        'pt_PT',
        'nb_NO',
        'sv_SE',
        'fi_FI',
        'da_DK',
        'is_IS',
        'hu_HU',
        'pl_PL',
        'lv_LV',
        'lt_LT',
    ];

    /**
     * Vertaal de taalsnaam (zoals opgeslagen in Language.name) naar een Mollie-ondersteunde locale.
     * Talen die Mollie niet kent vallen terug op nl_BE.
     */
    private function resolveLocale(?string $languageName): string
    {
        $locale = match (strtolower(trim($languageName ?? ''))) {
            'engels', 'english'              => 'en_US',
            'frans', 'français', 'french'    => 'fr_BE',
            'duits', 'deutsch', 'german'     => 'de_DE',
            'spaans', 'español', 'spanish'   => 'es_ES',
            'italiaans', 'italiano', 'italian' => 'it_IT',
            'portugees', 'português',
            'portuguese'                     => 'pt_PT',
            'noors', 'norsk', 'norwegian'    => 'nb_NO',
            'zweeds', 'svenska', 'swedish'   => 'sv_SE',
            'fins', 'suomi', 'finnish'       => 'fi_FI',
            'deens', 'dansk', 'danish'       => 'da_DK',
            'ijslands', 'íslenska',
            'icelandic'                      => 'is_IS',
            'hongaars', 'magyar', 'hungarian' => 'hu_HU',
            'pools', 'polski', 'polish'      => 'pl_PL',
            'lets', 'latviešu', 'latvian'    => 'lv_LV',
            'litouws', 'lietuvių',
            'lithuanian'                     => 'lt_LT',
            default                          => 'nl_BE',
        };

        // Veiligheidsnet: als de locale om welke reden dan ook niet door Mollie herkend wordt, nl_BE
        return in_array($locale, self::MOLLIE_LOCALES, true) ? $locale : 'nl_BE';
    }

    /**
     * Stel de factuurbeschrijving op in de juiste taal.
     */
    private function buildDescription(TimeSlot $timeSlot, string $locale): string
    {
        $room  = $timeSlot->room->name;
        $date  = $timeSlot->start_time->format('d/m/Y');
        $start = $timeSlot->start_time->format('H:i');
        $end   = $timeSlot->end_time->format('H:i');

        $prefix = match (substr($locale, 0, 2)) {
            'en'    => 'Escape room',
            'fr'    => 'Salle d\'évasion',
            'de'    => 'Escape Room',
            'es', 'ca' => 'Sala de escape',
            'it'    => 'Stanza di fuga',
            'pt'    => 'Sala de escape',
            'nb'    => 'Escape room',
            'sv'    => 'Escape room',
            'fi'    => 'Pakohuone',
            'da'    => 'Escape room',
            'is'    => 'Escape room',
            'hu'    => 'Szabadulószoba',
            'pl'    => 'Escape room',
            'lv'    => 'Escape room',
            'lt'    => 'Escape room',
            default => 'Escape room',
        };

        return "{$prefix} {$room} – {$date} {$start}–{$end}";
    }
}
