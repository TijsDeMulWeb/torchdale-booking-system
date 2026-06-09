<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['escaperoom_id', 'type', 'locale', 'subject', 'body'])]
class MailTemplate extends Model
{
    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }

    public function render(array $variables): string
    {
        $body = $this->body;
        foreach ($variables as $key => $value) {
            $body = str_replace('{{' . $key . '}}', e((string) $value), $body);
        }
        return $body;
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

    public static function resolveFor(int $escaperoomId, string $type, string $locale): ?self
    {
        return self::where('escaperoom_id', $escaperoomId)
            ->where('type', $type)
            ->where('locale', $locale)
            ->first()
            ?? self::where('escaperoom_id', $escaperoomId)
                ->where('type', $type)
                ->where('locale', 'nl')
                ->first();
    }
}
