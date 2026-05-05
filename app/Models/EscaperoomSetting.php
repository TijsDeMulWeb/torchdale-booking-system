<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EscaperoomSetting extends Model
{
    protected $casts = [
        'mollie_api_key' => 'encrypted',
        'openai_api_key' => 'encrypted',
    ];

    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }
}
