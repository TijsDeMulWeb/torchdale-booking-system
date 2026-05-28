<?php

namespace App\Http\Controllers\GiftCard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexGiftCardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $giftCards = auth()->user()->escaperoom->giftCards()->paginate(10);
            
        return view('giftCard.index', [
            'giftCards' => $giftCards,
        ]);
    }
}
