<?php

namespace App\Http\Controllers\GiftCard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateGiftCardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('giftCards.create');
    }
}
