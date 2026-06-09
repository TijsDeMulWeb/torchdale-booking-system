<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\ProductVariant;

class UpdateProductController extends Controller
{
    public function __invoke(ProductRequest $request, int $id)
    {
        $product = auth()->user()->escaperoom->products()->findOrFail($id);
        abort_if($product->escaperoom_id !== auth()->user()->escaperoom_id, 403);

        $product->update($request->validated());

        $this->syncVariants($product, $request->input('variants', []));

        return redirect()->route('products.index')->with('message', 'Product updated successfully.');
    }

    private function syncVariants($product, array $variants): void
    {
        $keptIds = [];

        foreach ($variants as $i => $row) {
            if (empty($row['name'])) continue;

            $sellingPrice  = ($row['selling_price'] ?? '') !== '' ? $row['selling_price'] : null;
            $stockQuantity = ($row['stock_quantity'] ?? '') !== '' ? (int) $row['stock_quantity'] : null;

            if (! empty($row['id'])) {
                $variant = ProductVariant::withTrashed()->find((int) $row['id']);
                if ($variant && $variant->product_id === $product->id) {
                    $variant->restore();
                    $variant->update([
                        'name'           => $row['name'],
                        'sku'            => $row['sku'] ?? null,
                        'selling_price'  => $sellingPrice,
                        'stock_quantity' => $stockQuantity,
                        'sort_order'     => $i,
                    ]);
                    $keptIds[] = $variant->id;
                }
            } else {
                $variant = $product->variants()->create([
                    'name'           => $row['name'],
                    'sku'            => $row['sku'] ?? null,
                    'selling_price'  => $sellingPrice,
                    'stock_quantity' => $stockQuantity,
                    'sort_order'     => $i,
                ]);
                $keptIds[] = $variant->id;
            }
        }

        // Soft-delete variants not in the submitted list
        $product->variants()->whereNotIn('id', $keptIds)->delete();
    }
}
