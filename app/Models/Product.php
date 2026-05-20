<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['category_id', 'name', 'description', 'cost_price', 'selling_price', 'vat_percentage', 'discount_type', 'discount_value', 'sku', 'stock_quantity', 'available_from'])]
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

    public function product_images()
    {
        return $this->hasMany(ProductImage::class, 'products');
    }

    protected function casts(): array
    {
        return [
            'available_from' => 'datetime',
        ];
    }
}
