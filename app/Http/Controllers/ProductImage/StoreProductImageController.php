<?php

namespace App\Http\Controllers\ProductImage;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductImageRequest;
use Illuminate\Http\Request;

class StoreProductImageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreProductImageRequest $request, int $id)
    {
        $validated = $request->validated();
        $alreadyAPrimaryImage = false;

        $product = auth()->user()->escaperoom->products()->findOrFail($id);
        $productImages = $product->product_images()->get();
        abort_if($product->escaperoom_id !== auth()->user()->escaperoom_id, 403);

        if ($request->hasFile('product_image')) {
            $validated['image_url'] = $request->file('product_image')->store('escaperooms/' . auth()->user()->escaperoom->id . '/products/' . $product->id, 'public');
        }

        foreach ($productImages as $productImage) {
            if ($productImage->is_primary == true) {
                $alreadyAPrimaryImage = true;
            }
        }

        if ($alreadyAPrimaryImage == false) {
            $validated['is_primary'] = true;
        }

        if ($alreadyAPrimaryImage == true && ($validated['is_primary']) == true) {
            foreach ($productImages as $productImage) {
                $productImage->update(['is_primary' => false]);
            }
        }

        unset($validated['product_image']);

        $product->product_images()->create(
            [
                'url' => $validated['image_url'],
                'alt_text' => $validated['alt_text'],
                'is_primary' => $validated['is_primary'] ?? false,
            ]
        );

        return redirect()->route('products.edit', $product->id)->with('message', 'Product Image succesvol toegevoegd.');
    }
}
