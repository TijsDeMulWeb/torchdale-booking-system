<?php

namespace App\Http\Controllers\ProductImage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeleteProductImageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id, int $imageId)
    {
        $product = auth()->user()->escaperoom->products()->findOrFail($id);
        $productImage = $product->product_images()->findOrFail($imageId);
        abort_if($product->escaperoom_id !== auth()->user()->escaperoom_id, 403);

        Storage::disk('public')->delete($productImage->url);

        $productImage->delete();

        return redirect()->route('products.index')->with('message', 'Product Image succesvol verwijderd.');
    }
}
