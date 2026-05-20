<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;

class UpdateProductController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ProductRequest $request, int $id)
    {
        $product = auth()->user()->escaperoom->products()->findOrFail($id);
        abort_if($product->escaperoom_id !== auth()->user()->escaperoom_id, 403);

        $product->update($request->validated());

        return redirect()->route('products.index')->with('message', 'Product updated successfully.');
    }
}
