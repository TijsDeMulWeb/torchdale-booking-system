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
        $productFilter = fn($query) => $query
            ->where('available_from', '<=', now())
            ->where('stock_quantity', '>', 0);
            
        if ($request->category_id) {
            $categories = $request->escaperoom->categories()
                ->where('id', $request->category_id)
                ->whereHas('products', $productFilter)
                ->with(['products' => $productFilter, 'products.product_images'])
                ->get();

            return response()->json(['success' => true, 'categories' => $categories]);
        }

        $categories = $request->escaperoom->categories()
            ->whereHas('products', $productFilter)
            ->with(['products' => $productFilter, 'products.product_images'])
            ->get();

        return response()->json(['success' => true, 'categories' => $categories]);
    }
}
