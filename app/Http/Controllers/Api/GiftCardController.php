<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GiftCardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $giftCards = $request->escaperoom->giftCards()->get();

        return response()->json(['success' => true, 'gift_cards' => $giftCards]);
    }
}
