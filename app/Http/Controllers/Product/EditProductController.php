<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class EditProductController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $product = auth()->user()->escaperoom->products()->with('category')->findOrFail($id);
        $categories = ProductCategory::where('escaperoom_id', auth()->user()->escaperoom_id)->get();
        abort_if($product->escaperoom_id !== auth()->user()->escaperoom_id, 403);

        return view('products.edit', [
            'product' => $product,
            'categories' => $categories
        ]);
    }
}
