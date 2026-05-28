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
        $giftCards = auth()->user()->escaperoom->giftCards()
            ->with('customer')
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('code', 'like', '%' . $request->search . '%')
                        ->orWhereHas('customer', function ($q2) use ($request) {
                            $q2->where('first_name', 'like', '%' . $request->search . '%')
                                ->orWhere('last_name', 'like', '%' . $request->search . '%');
                        });
                });
            })
            ->paginate(10);
            
        return view('giftCard.index', [
            'giftCards' => $giftCards,
        ]);
    }
}
