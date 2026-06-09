<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'iso_code'])]
class Country extends Model
{
    /**
     * Vertaal een landnaam of ISO-code naar een genormaliseerde 2-letter ISO-code.
     * Bv. "Belgium", "België", "be" → "BE". Onbekende waarden → uppercase van input.
     */
    public static function resolveIso(string $value): string
    {
        $value = trim($value);
        if ($value === '') {
            return 'BE';
        }

        // Al een geldige 2-letter code
        if (strlen($value) === 2) {
            return strtoupper($value);
        }

        $country = static::whereRaw('LOWER(name) = ?', [strtolower($value)])
            ->orWhere('iso_code', strtoupper($value))
            ->first();

        return $country?->iso_code ?? strtoupper(substr($value, 0, 2));
    }

    public function escaperoomAddresses()
    {
        return $this->hasMany(EscaperoomAddress::class);
    }
}
