<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\ProductCategory;
class StoreCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CategoryRequest $request)
    {
        Auth()->user()->escaperoom->categories()->create($request->validated());

        return redirect()->route('products.index')->with('message', 'Category created successfully.');
    }
}
