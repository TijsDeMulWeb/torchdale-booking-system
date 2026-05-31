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
        $categories = $request->escaperoom->categories()->with('products')->get();

        return response()->json(['success' => true, 'categories' => $categories]);
    }
}
