<?php

namespace App\Models;

use App\Support\ContactNormalizer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['escaperoom_id', 'first_name', 'last_name', 'email', 'phone', 'street', 'house_number', 'postal_code', 'city', 'country', 'banned_at', 'ip_address'])]
class Customer extends Model
{
    use SoftDeletes;
    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function identifiers()
    {
        return $this->hasMany(CustomerIdentifier::class);
    }

    public function mailLogs()
    {
        return $this->hasMany(MailLog::class);
    }

    public function giftVouchers()
    {
        return $this->hasMany(GiftVoucher::class);
    }

    protected function casts(): array
    {
        return [
            'banned_at' => 'datetime',
        ];
    }

    public function getNextAppointmentAttribute(): ?\Illuminate\Support\Carbon
    {
        return $this->orders()
            ->where('status', 'paid')
            ->with(['orderedItems.timeSlot'])
            ->get()
            ->flatMap(fn($order) => $order->orderedItems)
            ->filter(fn($item) => $item->time_slot_id && $item->timeSlot)
            ->map(fn($item) => $item->timeSlot->start_time)
            ->filter(fn($date) => $date->isFuture())
            ->sort()
            ->first();
    }

    public function getPreviousAppointmentAttribute(): ?\Illuminate\Support\Carbon
    {
        return $this->orders()
            ->where('status', 'paid')
            ->with(['orderedItems.timeSlot'])
            ->get()
            ->flatMap(fn($order) => $order->orderedItems)
            ->filter(fn($item) => $item->time_slot_id && $item->timeSlot)
            ->map(fn($item) => $item->timeSlot->start_time)
            ->filter(fn($date) => $date->isPast())
            ->sortDesc()
            ->first();
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getFullAddressAttribute(): string
    {
        $address = $this->street . ' ' . $this->house_number;

        if ($this->address_line_2) {
            $address .= ' ' . $this->address_line_2;
        }

        $address .= ', ' . $this->city . ' ' . $this->postal_code . ', ' . $this->country;

        return $address;
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucFirst(strtolower(trim($value)));
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucwords(strtolower(trim($value)));
    }

    public function setEmailAttribute($value)
    {
        $email = strtolower(trim($value));
        $this->attributes['email'] = $email;
        $this->attributes['email_normalized'] = ContactNormalizer::normalizeEmail($email);
    }

    public function setPhoneAttribute($value)
    {
        $phone = $value !== null ? trim($value) : $value;
        $this->attributes['phone'] = $phone;
        $this->attributes['phone_normalized'] = ContactNormalizer::normalizePhone($phone);
    }

    public function setStreetAttribute($value)
    {
        $this->attributes['street'] = ucwords(strtolower(trim($value)));
    }

    public function setCityAttribute($value)
    {
        $this->attributes['city'] = ucwords(strtolower(trim($value)));
    }

    public function setCountryAttribute($value)
    {
        $this->attributes['country'] = Country::resolveIso($value ?? '');
    }
}
