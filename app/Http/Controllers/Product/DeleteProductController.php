<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteProductController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $product = auth()->user()->escaperoom->products()->findOrFail($id);
        abort_if($product->escaperoom_id !== auth()->user()->escaperoom_id, 403);

        $product->delete();
        return redirect()->route('products.index')->with('message', 'Product deleted successfully.');
    }
}
