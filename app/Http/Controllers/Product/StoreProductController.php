<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;

class StoreProductController extends Controller
{
    public function __invoke(ProductRequest $request)
    {
        $product = auth()->user()->escaperoom->products()->create($request->validated());

        $this->syncVariants($product, $request->input('variants', []));

        return redirect()->route('products.index')->with('message', 'Product created successfully.');
    }

    private function syncVariants($product, array $variants): void
    {
        foreach ($variants as $i => $row) {
            if (empty($row['name'])) continue;
            $product->variants()->create([
                'name'           => $row['name'],
                'sku'            => $row['sku'] ?? null,
                'selling_price'  => $row['selling_price'] !== '' ? $row['selling_price'] : null,
                'stock_quantity' => $row['stock_quantity'] !== '' ? (int) $row['stock_quantity'] : null,
                'sort_order'     => $i,
            ]);
        }
    }
}
