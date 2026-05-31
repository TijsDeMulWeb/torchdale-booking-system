<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowRoomPriceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        return view('rooms.prices', [
            'room' => auth()->user()->escaperoom->rooms()->findOrFail($id),
            'pricings' => auth()->user()->escaperoom->rooms()->findOrFail($id)
                ->prices()
                ->get()
                ->groupBy('day_of_week')
                ->map(fn($rows) => [
                    'base_price' => $rows->first()->base_price,
                    'vat_percentage' => $rows->first()->vat_percentage,
                    'payment_location' => $rows->first()->payment_location,
                    'players' => $rows->keyBy('player_amount'),
                ]),
            'last_updated' => auth()->user()->escaperoom->rooms()->findOrFail($id)->prices()->latest('updated_at')->first(),
        ]);
    }
}
