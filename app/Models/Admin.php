<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Fillable(['escaperoom_id', 'first_name', 'last_name', 'email', 'password'])]
#[Hidden(['password'])]
class Admin extends Authenticatable
{
    use SoftDeletes;
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
