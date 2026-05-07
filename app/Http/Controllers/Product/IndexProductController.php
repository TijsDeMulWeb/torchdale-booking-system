<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexProductController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('products.index', [
            'products' => auth()->user()->escaperoom->products()->with('category')->paginate(5),
        ]);
    }
}
