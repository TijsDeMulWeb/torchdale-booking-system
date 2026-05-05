<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function chatbots()
    {
        return $this->hasMany(Chatbot::class);
    }
}
