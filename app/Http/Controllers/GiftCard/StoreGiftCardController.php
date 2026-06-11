<?php

namespace App\Http\Controllers\GiftCard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGiftCardRequest;

class StoreGiftCardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreGiftCardRequest $request)
    {
        $validated = $request->validated();
        $imageFile = $validated['image'] ?? null;
        unset($validated['image']);

        $giftCard = auth()->user()->escaperoom->giftCards()->create($validated);

        if ($imageFile) {
            $giftCard->image = $imageFile->store(
                'escaperooms/' . auth()->user()->escaperoom->id . '/giftcards/' . $giftCard->id,
                'public'
            );
            $giftCard->save();
        }

        return redirect()->route('giftCards.index')->with('message', 'Cadeaubon succesvol aangemaakt.');
    }
}
