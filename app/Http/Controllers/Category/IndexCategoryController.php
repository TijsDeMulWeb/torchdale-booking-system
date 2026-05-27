<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('category.index', [
            'categories' => auth()->user()
                ->escaperoom
                ->categories()
                ->withCount('products')
                ->orderBy('name')
                ->paginate(5),
        ]);
    }
}
