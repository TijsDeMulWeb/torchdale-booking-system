<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $product)
    {
        $product = $request->escaperoom->products()
            ->where('available_from', '<=', now()->endOfDay())
            ->with(['product_images', 'variants', 'category'])
            ->find($product);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
        }

        return response()->json(['success' => true, 'product' => $product]);
    }
}
