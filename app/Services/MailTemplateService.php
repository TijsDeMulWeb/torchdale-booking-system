<?php

namespace App\Services;

use App\Mail\TemplatedMail;
use App\Models\GiftVoucher;
use App\Models\MailTemplate;
use App\Models\Order;
use App\Models\OrderedItem;
use App\Models\TimeSlot;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MailTemplateService
{
    /**
     * Verstuur het mail-sjabloon van een product (indien aanwezig) naar de klant van de order.
     */
    public function sendForProductItem(OrderedItem $item, Order $order): void
    {
        if (! $item->product_id) {
            return;
        }

        $locale   = MailTemplate::localeFromCountry($order->customer?->country);
        $template = MailTemplate::resolveFor($order->escaperoom_id, 'product', $locale);

        if (! $template) {
            return;
        }

        $product = $item->product;
        $variant = $item->productVariant;

        $productImage = $product?->product_images?->firstWhere('is_primary', true)
            ?? $product?->product_images?->first();

        $variables = [
            'customer_name'  => trim($order->customer_first_name . ' ' . $order->customer_last_name),
            'customer_email' => $order->customer_email,
            'order_number'   => $order->invoice_number ?? ('#' . $order->id),
            'product_name'   => $product?->name ?? '',
            'variant_name'   => $variant?->name ?? '',
            'quantity'       => (string) $item->quantity,
            'product_image'  => $productImage
                ? '<img src="' . asset(Storage::url($productImage->url)) . '" alt="" style="max-width:100%;border-radius:8px;">'
                : '',
        ];

        try {
            Mail::to($order->customer_email)->send(new TemplatedMail($template, $variables));
        } catch (\Exception $e) {
            Log::error("MailTemplateService: versturen productmail mislukt voor order #{$order->id}: " . $e->getMessage());
        }
    }

    /**
     * Verstuur het mail-sjabloon van een cadeaubon (indien aanwezig) naar de klant van de order.
     */
    public function sendForGiftVoucher(GiftVoucher $voucher, Order $order): void
    {
        if (! $voucher->gift_card_id) {
            return;
        }

        $locale   = MailTemplate::localeFromCountry($order->customer?->country);
        $template = MailTemplate::resolveFor($order->escaperoom_id, 'gift-card', $locale);

        if (! $template) {
            return;
        }

        $giftCard = $voucher->giftCard;

        $variables = [
            'customer_name'   => trim($order->customer_first_name . ' ' . $order->customer_last_name),
            'customer_email'  => $order->customer_email,
            'order_number'    => $order->invoice_number ?? ('#' . $order->id),
            'gift_card_name'  => $giftCard?->name ?? '',
            'voucher_code'    => $voucher->code,
            'voucher_amount'  => number_format((float) $voucher->amount, 2, ',', '.') . ' €',
            'valid_until'     => $voucher->valid_until?->format('d/m/Y') ?? '',
        ];

        try {
            Mail::to($order->customer_email)->send(new TemplatedMail($template, $variables));
        } catch (\Exception $e) {
            Log::error("MailTemplateService: versturen cadeaubon-mail mislukt voor order #{$order->id}: " . $e->getMessage());
        }
    }

    /**
     * Verstuur het mail-sjabloon van een kamer (indien aanwezig) naar de klant van de order,
     * eventueel met een agenda-bijlage (.ics) voor de afspraak.
     */
    public function sendForRoomBooking(TimeSlot $timeSlot, Order $order): void
    {
        $room = $timeSlot->room;

        if (! $room) {
            return;
        }

        $locale   = MailTemplate::localeFromCountry($order->customer?->country);
        $template = MailTemplate::resolveFor($order->escaperoom_id, 'room', $locale, $room->id);

        if (! $template) {
            return;
        }

        $address = $room->escaperoomAddress?->full_address;
        $players = $order->orderedItems()->where('time_slot_id', $timeSlot->id)->sum('quantity');

        $variables = [
            'customer_name'  => trim($order->customer_first_name . ' ' . $order->customer_last_name),
            'customer_email' => $order->customer_email,
            'order_number'   => $order->invoice_number ?? ('#' . $order->id),
            'room_name'      => $room->name,
            'date'           => $timeSlot->start_time->translatedFormat('d/m/Y'),
            'start_time'     => $timeSlot->start_time->format('H:i'),
            'end_time'       => $timeSlot->end_time->format('H:i'),
            'players'        => (string) $players,
            'address'        => $address ?? '',
        ];

        $attachments = [];
        if ($template->attach_ics) {
            $attachments[] = [
                'data'     => $this->buildIcsContent($timeSlot, $order, $room->name, $address),
                'filename' => 'afspraak.ics',
                'mime'     => 'text/calendar',
            ];
        }

        try {
            Mail::to($order->customer_email)->send(new TemplatedMail($template, $variables, $attachments));
        } catch (\Exception $e) {
            Log::error("MailTemplateService: versturen room-mail mislukt voor order #{$order->id}: " . $e->getMessage());
        }
    }

    /**
     * Bouw een .ics-bestand (iCalendar) op voor de afspraak van een tijdslot.
     */
    private function buildIcsContent(TimeSlot $timeSlot, Order $order, string $roomName, ?string $address): string
    {
        $uid = 'booking-' . $order->id . '-' . $timeSlot->id . '@' . parse_url(config('app.url'), PHP_URL_HOST);

        $lines = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//Torchdaleplanner//Booking//NL',
            'CALSCALE:GREGORIAN',
            'METHOD:PUBLISH',
            'BEGIN:VEVENT',
            'UID:' . $uid,
            'DTSTAMP:' . now()->utc()->format('Ymd\THis\Z'),
            'DTSTART:' . $timeSlot->start_time->clone()->utc()->format('Ymd\THis\Z'),
            'DTEND:' . $timeSlot->end_time->clone()->utc()->format('Ymd\THis\Z'),
            'SUMMARY:' . $this->icsEscape($roomName),
            'LOCATION:' . $this->icsEscape($address ?? ''),
            'END:VEVENT',
            'END:VCALENDAR',
        ];

        return implode("\r\n", $lines) . "\r\n";
    }

    private function icsEscape(string $value): string
    {
        return str_replace(["\\", "\n", ',', ';'], ['\\\\', '\\n', '\\,', '\\;'], $value);
    }
}
