<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $availableProducts = fn($query) => $query->where('available_from', '<=', now());

        if ($request->category_id) {
            $categories = $request->escaperoom->categories()
                ->where('id', $request->category_id)
                ->whereHas('products', $availableProducts)
                ->with(['products' => $availableProducts, 'products.product_images'])
                ->get();

            return response()->json(['success' => true, 'categories' => $categories]);
        }

        $categories = $request->escaperoom->categories()
            ->whereHas('products', $availableProducts)
            ->with(['products' => $availableProducts, 'products.product_images'])
            ->get();

        return response()->json(['success' => true, 'categories' => $categories]);
    }
}
