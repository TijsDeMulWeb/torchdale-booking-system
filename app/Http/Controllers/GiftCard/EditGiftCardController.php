<?php

namespace App\Http\Controllers\GiftCard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GiftCard;

class EditGiftCardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $giftCard = auth()->user()->escaperoom->giftCards()->findOrFail($id);
        abort_if($giftCard->escaperoom_id !== auth()->user()->escaperoom_id, 403);

        return view('giftCard.edit', [
            'giftCard' => $giftCard,
        ]);
    }
}
