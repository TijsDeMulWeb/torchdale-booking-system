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
        auth()->user()->escaperoom()->giftCards()->create($request->validated());
        return redirect()->route('giftCards.index')->with('message', 'Cadeaubon succesvol aangemaakt.');
    }
}
