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
        if(ProductCategory::where('name', $request->name)->where('escaperoom_id', auth()->user()->escaperoom_id)->exists()) {
            return redirect()->route('categories.index')->withErrors(['message' => 'A category with this name already exists.']);
        }

        Auth()->user()->escaperoom->categories()->create($request->validated());

        return redirect()->route('categories.index')->with('message', 'Category created successfully.');
    }
}
