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
        $giftCards = auth()->user()->escaperoom
            ->giftCards()
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->paginate(10)
            ->withQueryString();

        return view('giftCard.index', [
            'giftCards' => $giftCards,
        ]);
    }
}
