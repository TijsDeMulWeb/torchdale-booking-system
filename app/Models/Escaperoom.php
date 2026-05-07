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
}
