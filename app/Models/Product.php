<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['category_id', 'name', 'description', 'cost_price', 'selling_price', 'vat_percentage', 'discount_type', 'discount_value', 'sku', 'stock_quantity', 'available_from'])]
class Product extends Model
{
    use SoftDeletes;
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
        return $this->hasMany(ProductImage::class);
    }

    public function orderedItems()
    {
        return $this->hasMany(OrderedItem::class);
    }

    protected function casts(): array
    {
        return [
            'available_from' => 'datetime',
        ];
    }
}
