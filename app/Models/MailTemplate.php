<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['escaperoom_id', 'type', 'room_id', 'locale', 'subject', 'body', 'attach_ics'])]
class MailTemplate extends Model
{
    protected function casts(): array
    {
        return [
            'attach_ics' => 'boolean',
        ];
    }

    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Variabelen waarvan de waarde zelf HTML bevat en dus niet ge-escaped mag worden.
     */
    private const RAW_VARIABLES = ['product_image'];

    public function render(array $variables): string
    {
        $body = $this->body;
        foreach ($variables as $key => $value) {
            $replacement = in_array($key, self::RAW_VARIABLES, true) ? (string) $value : e((string) $value);
            $body = str_replace('{{' . $key . '}}', $replacement, $body);
        }
        return nl2br($body);
    }

    public function renderSubject(array $variables): string
    {
        $subject = $this->subject;
        foreach ($variables as $key => $value) {
            $subject = str_replace('{{' . $key . '}}', (string) $value, $subject);
        }
        return $subject;
    }

    public static function locales(): array
    {
        return [
            'nl' => 'Nederlands',
            'en' => 'English',
            'fr' => 'Français',
            'de' => 'Deutsch',
        ];
    }

    /**
     * Leid de mailtaal af van een 2-letter ISO landcode van de klant.
     */
    public static function localeFromCountry(?string $countryIso): string
    {
        $map = [
            'NL' => 'nl',
            'BE' => 'nl',
            'FR' => 'fr',
            'DE' => 'de',
            'AT' => 'de',
            'CH' => 'de',
            'GB' => 'en',
            'IE' => 'en',
            'US' => 'en',
        ];

        return $map[strtoupper((string) $countryIso)] ?? 'nl';
    }

    public static function resolveFor(int $escaperoomId, string $type, string $locale, int $roomId = 0): ?self
    {
        return self::where('escaperoom_id', $escaperoomId)
            ->where('type', $type)
            ->where('room_id', $roomId)
            ->where('locale', $locale)
            ->first()
            ?? self::where('escaperoom_id', $escaperoomId)
                ->where('type', $type)
                ->where('room_id', $roomId)
                ->where('locale', 'nl')
                ->first();
    }
}
