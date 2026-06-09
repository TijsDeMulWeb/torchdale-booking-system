<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\GiftCard;
use App\Models\Product;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class ShowCheckoutController extends Controller
{
    public function __invoke()
    {
        $escaperoom = auth()->user()->escaperoom;

        $rooms = Room::where('escaperoom_id', $escaperoom->id)
            ->with('prices')
            ->get();

        $products = Product::where('escaperoom_id', $escaperoom->id)
            ->get();

        $giftCards = GiftCard::where('escaperoom_id', $escaperoom->id)
            ->get();

        $countries = DB::table('countries')->orderBy('name')->get(['id', 'name']);

        return view('order.checkout', compact('rooms', 'products', 'giftCards', 'countries'));
    }
}
