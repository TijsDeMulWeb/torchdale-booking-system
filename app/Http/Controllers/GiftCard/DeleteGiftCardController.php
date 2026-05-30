<?php

namespace App\Http\Controllers\GiftCard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteGiftCardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $giftCard = auth()->user()->escaperoom->giftCards()->findOrFail($id);

        abort_if($giftCard->escaperoom_id !== auth()->user()->escaperoom_id, 403);
        
        $giftCard->delete();

        return redirect()->route('giftCards.index')->with('message', 'Cadeaubon succesvol verwijderd.');
    }
}
