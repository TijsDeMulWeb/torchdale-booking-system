<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'phone', 'email', 'invoice_email', 'vat_number', 'registration_number', 'logo_url'])]
class Escaperoom extends Model
{
    public function escaperoomAddresses()
    {
        return $this->hasMany(EscaperoomAddress::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function escaperoomSetting()
    {
        return $this->hasOne(EscaperoomSetting::class);
    }

    public function chatbot()
    {
        return $this->hasOne(Chatbot::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function categories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function giftCards()
    {
        return $this->hasMany(GiftCard::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function apiKeys()
    {
        return $this->hasMany(ApiKey::class);
    }
}
