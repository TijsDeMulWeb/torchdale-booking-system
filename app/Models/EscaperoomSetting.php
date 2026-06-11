<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['escaperoom_id', 'mollie_api_key', 'openai_api_key', 'widget_color_primary', 'widget_color_primary_dark', 'widget_color_background_dark', 'widget_color_text', 'widget_color_sale', 'widget_color_success', 'confirmation_room_url', 'confirmation_product_url', 'confirmation_gift_card_url', 'reminder_days_before', 'notify_new_order', 'hear_about_us_options', 'collect_player_names'])]
class EscaperoomSetting extends Model
{
    protected $casts = [
        'notify_new_order' => 'boolean',
        'hear_about_us_options' => 'array',
        'collect_player_names' => 'boolean',
    ];

    // No 'encrypted' cast — that uses serialize:false which conflicts with the decrypt() helper.
    // We use explicit get/set accessors with encrypt()/decrypt() (serialize:true) instead.

    public function getMollieApiKeyAttribute(?string $value): ?string
    {
        if (!$value) return null;
        try { return decrypt($value); } catch (\Exception) { return $value; }
    }

    public function setMollieApiKeyAttribute(?string $value): void
    {
        $this->attributes['mollie_api_key'] = $value ? encrypt($value) : null;
    }

    public function getOpenaiApiKeyAttribute(?string $value): ?string
    {
        if (!$value) return null;
        try { return decrypt($value); } catch (\Exception) { return $value; }
    }

    public function setOpenaiApiKeyAttribute(?string $value): void
    {
        $this->attributes['openai_api_key'] = $value ? encrypt($value) : null;
    }

    public function getEscaperoomApiKeyAttribute(?string $value): ?string
    {
        if (!$value) return null;
        try { return decrypt($value); } catch (\Exception) { return $value; }
    }

    public function setEscaperoomApiKeyAttribute(?string $value): void
    {
        $this->attributes['escaperoom_api_key'] = $value ? encrypt($value) : null;
    }

    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }
}
