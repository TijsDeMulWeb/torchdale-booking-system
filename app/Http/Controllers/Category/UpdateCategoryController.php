<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\ProductCategory;

class UpdateCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CategoryRequest $request, int $id)
    {
        $category = ProductCategory::findOrFail($id);
        abort_if($category->escaperoom_id !== auth()->user()->escaperoom_id, 403);

        $category->update($request->validated());

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }
}
