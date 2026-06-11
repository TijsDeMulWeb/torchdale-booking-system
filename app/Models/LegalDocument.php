<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['escaperoom_id', 'type', 'version', 'file_path', 'original_filename'])]
class LegalDocument extends Model
{
    public const TYPE_PRIVACY_POLICY = 'privacy_policy';
    public const TYPE_TERMS_CONDITIONS = 'terms_conditions';

    public const TYPES = [
        self::TYPE_PRIVACY_POLICY,
        self::TYPE_TERMS_CONDITIONS,
    ];

    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }
}
