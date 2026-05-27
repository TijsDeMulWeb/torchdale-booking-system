<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name'])]
class ProductCategory extends Model
{
    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
