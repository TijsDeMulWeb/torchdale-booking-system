<?php

namespace App\Support;

class ContactNormalizer
{
    /**
     * Normalize an email address for matching purposes: lowercase, trimmed,
     * with "+alias" tags stripped and Gmail's dot-insensitivity applied.
     * This lets "jane.doe+booking@gmail.com" and "janedoe@gmail.com" be
     * recognized as the same inbox.
     */
    public static function normalizeEmail(?string $email): ?string
    {
        if (!$email) {
            return null;
        }

        $email = strtolower(trim($email));

        if (!str_contains($email, '@')) {
            return $email;
        }

        [$local, $domain] = explode('@', $email, 2);

        $local = preg_replace('/\+.*$/', '', $local);

        if (in_array($domain, ['gmail.com', 'googlemail.com'], true)) {
            $local = str_replace('.', '', $local);
            $domain = 'gmail.com';
        }

        return $local . '@' . $domain;
    }

    /**
     * Normalize a phone number to a comparable digits-only form (with leading
     * "+" and country code), so "+32 470 12 34 56", "0470 12 34 56" and
     * "0032470123456" all resolve to the same value.
     */
    public static function normalizePhone(?string $phone): ?string
    {
        if (!$phone) {
            return null;
        }

        $digits = preg_replace('/[^\d+]/', '', $phone);

        if ($digits === '' || $digits === '+') {
            return null;
        }

        if (str_starts_with($digits, '00')) {
            $digits = '+' . substr($digits, 2);
        } elseif (!str_starts_with($digits, '+')) {
            // Assume a Belgian local number (e.g. "0470 12 34 56") when no
            // country code is present.
            $digits = str_starts_with($digits, '0')
                ? '+32' . substr($digits, 1)
                : '+' . $digits;
        }

        return $digits;
    }
}
