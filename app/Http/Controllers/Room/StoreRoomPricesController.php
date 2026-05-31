<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoomPrice;

class StoreRoomPricesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $room = auth()->user()->escaperoom->rooms()->findOrFail($id);

        foreach ($request->pricings as $dayIndex => $data) {
            foreach ($data['players'] as $playerCount => $price) {
                RoomPrice::updateOrCreate(
                    [
                        'room_id' => $room->id,
                        'day_of_week' => $dayIndex,
                        'player_amount' => $playerCount,
                    ],
                    [
                        'base_price' => $data['base_price'],
                        'vat_percentage' => $data['vat_percentage'] ?? 21,
                        'price' => $price,
                    ]
                );
            }
        }

        return redirect()->route('rooms.prices.show', $room->id)->with('success', 'Prijzen succesvol bijgewerkt.');
    }
}
