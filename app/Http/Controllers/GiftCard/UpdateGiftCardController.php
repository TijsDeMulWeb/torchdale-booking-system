<?php

namespace App\Http\Controllers\GiftCard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGiftCardRequest;
use Illuminate\Http\Request;
use App\Models\GiftCard;
use Illuminate\Support\Facades\Storage;

class UpdateGiftCardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreGiftCardRequest $request, int $id)
    {
        $giftCard = GiftCard::findOrFail($id);
        abort_if($giftCard->escaperoom_id !== auth()->user()->escaperoom_id, 403);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($giftCard->image) {
                Storage::disk('public')->delete($giftCard->image);
            }

            $imageFile = $validated['image'];
            unset($validated['image']);

            $giftCard->update($validated);

            $giftCard->image = $imageFile->store(
                'escaperooms/' . auth()->user()->escaperoom->id . '/giftcards/' . $giftCard->id,
                'public'
            );
            $giftCard->save();
        } else {
            unset($validated['image']);
            $giftCard->update($validated);
        }

        return redirect()->route('giftCards.index')->with('message', 'Gift card updated successfully.');
    }
}
