<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class DeleteCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $category = ProductCategory::findOrFail($id);
        abort_if($category->escaperoom_id !== auth()->user()->escaperoom_id, 403);
        $category->delete();
        return redirect()->route('categories.index')->with('message', 'Categorie succesvol verwijderd.');
    }
}
