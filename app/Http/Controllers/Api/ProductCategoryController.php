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
        if ($request->category_id) {
            $categories = $request->escaperoom->categories()->where('id', $request->category_id)->with('products')->get();
            return response()->json(['success' => true, 'categories' => $categories]);
        }

        $categories = $request->escaperoom->categories()->with('products')->get();
        return response()->json(['success' => true, 'categories' => $categories]);
    }
}
