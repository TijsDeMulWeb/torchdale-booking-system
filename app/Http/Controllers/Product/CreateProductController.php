<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CreateProductController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $categories = ProductCategory::where('escaperoom_id', auth()->user()->escaperoom_id)->get();
        return view('products.create', [
            'categories' => $categories
        ]);
    }
}
