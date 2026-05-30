<?php

namespace App\Http\Controllers\GiftCard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGiftCardRequest;
use Illuminate\Http\Request;
use App\Models\GiftCard;

class UpdateGiftCardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreGiftCardRequest $request, int $id)
    {
        $giftCard = GiftCard::findOrFail($id);
        abort_if($giftCard->escaperoom_id !== auth()->user()->escaperoom_id, 403);

        $giftCard->update($request->validated());
        return redirect()->route('giftCards.index')->with('message', 'Gift card updated successfully.');
    }
}
