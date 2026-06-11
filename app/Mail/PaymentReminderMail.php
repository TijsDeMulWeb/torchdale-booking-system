<?php

namespace App\Mail;

use App\Models\Escaperoom;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    // NL: alleen Nederlandstalige landen
    private const NL_COUNTRIES = ['BE', 'NL'];

    // FR: Franstalige landen
    private const FR_COUNTRIES = ['FR', 'LU', 'MC'];

    public function __construct(
        public Order $order,
        public Escaperoom $escaperoom,
        public float $amountDue,
    ) {}

    public function envelope(): Envelope
    {
        $lang    = $this->resolveLanguage();
        $subject = match ($lang) {
            'fr'    => 'Rappel de paiement — ' . $this->escaperoom->name,
            'en'    => 'Payment reminder — ' . $this->escaperoom->name,
            default => 'Betalingsherinnering — ' . $this->escaperoom->name,
        };

        return new Envelope(
            from: new Address('info@torchdaleplanner.be', $this->escaperoom->name),
            subject: $subject,
        );
    }

    public function content(): Content
    {
        $customer     = $this->order->customer;
        $lang         = $this->resolveLanguage();
        $customerName = trim(
            ($customer?->first_name ?? $this->order->customer_first_name ?? '')
            . ' '
            . ($customer?->last_name ?? $this->order->customer_last_name ?? '')
        ) ?: ($lang === 'en' ? 'customer' : ($lang === 'fr' ? 'client' : 'klant'));

        $t = $this->translations($lang, $customerName, $this->escaperoom->name);

        return new Content(
            view: 'mails.paymentReminder',
            with: [
                'order'      => $this->order,
                'escaperoom' => $this->escaperoom,
                'amountDue'  => $this->amountDue,
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

    private function translations(string $lang, string $customerName, string $escaperoomName): array
    {
        return match ($lang) {
            'fr' => [
                'tag'           => 'RAPPEL DE PAIEMENT',
                'title'         => 'Votre paiement est toujours en attente',
                'greeting'      => "Bonjour <strong style=\"color:#d1d5db;\">{$customerName}</strong>, nous n'avons pas encore reçu le paiement de votre commande chez <strong style=\"color:#d1d5db;\">{$escaperoomName}</strong>.",
                'notice'        => "Vous trouverez ci-dessous un récapitulatif de votre commande, ainsi qu'un lien pour finaliser le paiement en ligne.",
                'order_label'   => 'DÉTAILS DE LA COMMANDE',
                'row_invoice'   => 'Numéro de facture',
                'row_total'     => 'Montant à payer',
                'pay_button'    => 'Payer maintenant',
                'closing'       => 'Des questions ? Contactez-nous via',
            ],
            'en' => [
                'tag'           => 'PAYMENT REMINDER',
                'title'         => 'Your payment is still pending',
                'greeting'      => "Hello <strong style=\"color:#d1d5db;\">{$customerName}</strong>, we have not yet received payment for your order at <strong style=\"color:#d1d5db;\">{$escaperoomName}</strong>.",
                'notice'        => 'Below you will find an overview of your order, along with a link to complete the payment online.',
                'order_label'   => 'ORDER DETAILS',
                'row_invoice'   => 'Invoice number',
                'row_total'     => 'Amount due',
                'pay_button'    => 'Pay now',
                'closing'       => 'Any questions? Contact us via',
            ],
            default => [ // nl
                'tag'           => 'BETALINGSHERINNERING',
                'title'         => 'Je betaling staat nog open',
                'greeting'      => "Hallo <strong style=\"color:#d1d5db;\">{$customerName}</strong>, we hebben de betaling van je bestelling bij <strong style=\"color:#d1d5db;\">{$escaperoomName}</strong> nog niet ontvangen.",
                'notice'        => 'Hieronder vind je een overzicht van je bestelling, samen met een link om online te betalen.',
                'order_label'   => 'BESTELGEGEVENS',
                'row_invoice'   => 'Factuurnummer',
                'row_total'     => 'Te betalen bedrag',
                'pay_button'    => 'Nu betalen',
                'closing'       => 'Heb je vragen? Neem contact op via',
            ],
        };
    }
}
