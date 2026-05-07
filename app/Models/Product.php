<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function escaperoom()
    {
        return $this->belongsTo(Escaperoom::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
