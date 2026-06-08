<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['escaperoom_id', 'first_name', 'last_name', 'email', 'password'])]
#[Hidden(['password'])]
class Admin extends Model
{
    use SoftDeletes;
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
