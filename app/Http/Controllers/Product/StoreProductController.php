<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;

class StoreProductController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ProductRequest $request)
    {
        auth()->user()->escaperoom->products()->create($request->validated());

        return redirect()->route('products.index')->with('message', 'Product created successfully.');
    }
}
