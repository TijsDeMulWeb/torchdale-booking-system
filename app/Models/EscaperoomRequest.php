<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['escaperoom_id', 'status', 'reviewed_at'])]
class EscaperoomRequest extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_DENIED = 'denied';

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
        ];
    }

    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }
}
