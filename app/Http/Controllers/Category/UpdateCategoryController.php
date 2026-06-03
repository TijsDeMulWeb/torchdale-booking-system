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

        if (ProductCategory::where('name', $request->name)->where('escaperoom_id', auth()->user()->escaperoom_id)->where('id', '!=', $id)->exists()) {
            return redirect()
                ->route('categories.edit', $id)
                ->withErrors(['name' => 'A category with this name already exists.']);
        }

        $category->update($request->validated());

        return redirect()->route('categories.index')->with('message', 'Category updated successfully.');
    }
}
