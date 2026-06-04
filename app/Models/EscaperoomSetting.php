<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['escaperoom_id', 'mollie_api_key', 'openai_api_key'])]
class EscaperoomSetting extends Model
{
    protected $casts = [
        'escaperoom_api_key' => 'encrypted',
        'mollie_api_key' => 'encrypted',
        'openai_api_key' => 'encrypted',
    ];

    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }
}
