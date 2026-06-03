<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['escaperoom_id', 'first_name', 'last_name', 'email', 'phone', 'password', 'profile_picture'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }

    public function giftCards()
    {
        return $this->hasMany(GiftCard::class, 'customer_id');
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function setFirstNameAttribute($value): void
    {
        $this->attributes['first_name'] = ucfirst(strtolower(trim($value)));
    }

    public function setLastNameAttribute($value): void
    {
        $this->attributes['last_name'] = ucWords(strtolower(trim($value)));
    }

    public function setEmailAttribute($value): void
    {
        $this->attributes['email'] = strtolower(trim($value));
    }

    public function setPhoneAttribute($value): void
    {
        $this->attributes['phone'] = preg_replace('/\D/', '', $value);
    }
}
