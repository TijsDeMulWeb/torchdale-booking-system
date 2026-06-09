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

    // NL: alleen Nederlandstalige landen
    private const NL_COUNTRIES = ['BE', 'NL'];

    // FR: Franstalige landen
    private const FR_COUNTRIES = ['FR', 'LU', 'MC'];

    public function __construct(
        public TimeSlot $timeSlot,
        public Order $order,
        public Escaperoom $escaperoom,
        public ?GiftVoucher $voucher = null,
    ) {}

    public function envelope(): Envelope
    {
        $lang    = $this->resolveLanguage();
        $subject = match ($lang) {
            'fr'    => 'Votre réservation chez ' . $this->escaperoom->name . ' a été annulée',
            'en'    => 'Your booking at ' . $this->escaperoom->name . ' has been cancelled',
            default => 'Je boeking bij ' . $this->escaperoom->name . ' is geannuleerd',
        };

        return new Envelope(
            from: new Address('info@torchdaleplanner.be', $this->escaperoom->name),
            subject: $subject,
        );
    }

    public function content(): Content
    {
        $customer     = $this->order->customer;
        $customerName = trim(
            ($customer?->first_name ?? $this->order->customer_first_name ?? '')
            . ' '
            . ($customer?->last_name ?? $this->order->customer_last_name ?? '')
        ) ?: ($this->resolveLanguage() === 'en' ? 'customer' : ($this->resolveLanguage() === 'fr' ? 'client' : 'klant'));

        $lang = $this->resolveLanguage();
        $t    = $this->translations($lang, $customerName, $this->escaperoom->name, $this->voucher !== null);

        return new Content(
            view: 'mails.bookingCancelled',
            with: [
                'timeSlot'   => $this->timeSlot,
                'order'      => $this->order,
                'escaperoom' => $this->escaperoom,
                'voucher'    => $this->voucher,
                't'          => $t,
            ],
        );
    }

    private function resolveLanguage(): string
    {
        $country = strtoupper(trim($this->order->customer?->country ?? 'BE'));
        if (in_array($country, self::FR_COUNTRIES, true)) return 'fr';
        if (in_array($country, self::NL_COUNTRIES, true)) return 'nl';
        return 'en'; // alle andere landen → Engels als internationale standaard
    }

    private function translations(string $lang, string $customerName, string $escaperoomName, bool $hasVoucher): array
    {
        $voucherSuffix = match ($lang) {
            'fr'    => ' Nous vous envoyons un bon cadeau en compensation.',
            'en'    => ' We are sending you a gift voucher as compensation.',
            default => ' We sturen je een cadeaubon mee als vergoeding.',
        };

        return match ($lang) {
            'fr' => [
                'tag'           => 'ANNULATION',
                'title'         => 'Votre réservation a été annulée',
                'greeting'      => "Bonjour <strong style=\"color:#d1d5db;\">{$customerName}</strong>, votre réservation chez <strong style=\"color:#d1d5db;\">{$escaperoomName}</strong> a été annulée." . ($hasVoucher ? $voucherSuffix : ''),
                'notice'        => "Votre réservation a été annulée. Des questions\u{00A0}? Contactez-nous via l'adresse e-mail ci-dessous.",
                'booking_label' => 'RÉSERVATION ANNULÉE',
                'row_room'      => 'Escape room',
                'row_date'      => 'Date',
                'row_time'      => 'Horaire',
                'row_players'   => 'Joueurs',
                'row_total'     => 'Total',
                'voucher_label' => 'VOTRE BON CADEAU',
                'voucher_body'  => "En compensation de l'annulation, nous avons créé un bon cadeau d'une valeur de",
                'voucher_intro' => 'Utilisez le code ci-dessous lors de votre prochaine réservation.',
                'voucher_code'  => 'CODE BON CADEAU',
                'valid_until'   => 'Valable jusqu\'au',
                'voucher_note'  => 'Conservez ce code précieusement. Mentionnez-le lors de votre prochaine réservation d\'escape room.',
                'closing'       => 'Des questions ou souhaitez-vous faire une nouvelle réservation ? Contactez-nous via',
            ],
            'en' => [
                'tag'           => 'CANCELLATION',
                'title'         => 'Your booking has been cancelled',
                'greeting'      => "Hello <strong style=\"color:#d1d5db;\">{$customerName}</strong>, your booking at <strong style=\"color:#d1d5db;\">{$escaperoomName}</strong> has been cancelled." . ($hasVoucher ? $voucherSuffix : ''),
                'notice'        => 'Your reservation has been cancelled. Any questions? Please contact us via the email address below.',
                'booking_label' => 'CANCELLED BOOKING',
                'row_room'      => 'Escape room',
                'row_date'      => 'Date',
                'row_time'      => 'Time',
                'row_players'   => 'Players',
                'row_total'     => 'Total',
                'voucher_label' => 'YOUR GIFT VOUCHER',
                'voucher_body'  => 'As compensation for the cancellation, we have created a gift voucher worth',
                'voucher_intro' => 'Use the code below for your next booking.',
                'voucher_code'  => 'GIFT VOUCHER CODE',
                'valid_until'   => 'Valid until',
                'voucher_note'  => 'Keep this code safe. Mention it when making your next escape room booking.',
                'closing'       => 'Questions or want to make a new booking? Contact us at',
            ],
            default => [ // nl
                'tag'           => 'ANNULERING',
                'title'         => 'Je boeking is geannuleerd',
                'greeting'      => "Hallo <strong style=\"color:#d1d5db;\">{$customerName}</strong>, je reservatie bij <strong style=\"color:#d1d5db;\">{$escaperoomName}</strong> is geannuleerd." . ($hasVoucher ? $voucherSuffix : ''),
                'notice'        => 'Je reservatie is geannuleerd. Heb je vragen? Neem contact op via het e-mailadres hieronder.',
                'booking_label' => 'GEANNULEERDE BOEKING',
                'row_room'      => 'Escape room',
                'row_date'      => 'Datum',
                'row_time'      => 'Tijdstip',
                'row_players'   => 'Spelers',
                'row_total'     => 'Totaal',
                'voucher_label' => 'JOUW CADEAUBON',
                'voucher_body'  => 'Als compensatie voor de annulering hebben we een cadeaubon aangemaakt ter waarde van',
                'voucher_intro' => 'Gebruik de code hieronder bij een volgende boeking.',
                'voucher_code'  => 'CADEAUBON CODE',
                'valid_until'   => 'Geldig tot',
                'voucher_note'  => 'Bewaar deze code goed. Vermeld hem bij het boeken van je volgende escape room.',
                'closing'       => 'Heb je vragen of wil je een nieuwe boeking maken? Neem contact op via',
            ],
        };
    }
}
