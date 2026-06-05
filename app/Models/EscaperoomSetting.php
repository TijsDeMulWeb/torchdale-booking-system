<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['escaperoom_id', 'mollie_api_key', 'openai_api_key', 'widget_color_primary', 'widget_color_primary_dark', 'widget_color_background_dark', 'widget_color_text', 'widget_color_sale', 'widget_color_success', 'confirmation_room_url', 'confirmation_product_url', 'confirmation_gift_card_url'])]
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
