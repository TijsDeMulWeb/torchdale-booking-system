<?php

namespace App\Http\Controllers\Room;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomPricesRequest;
use App\Models\RoomPrice;

class StoreRoomPricesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreRoomPricesRequest $request, int $id)
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
                        'payment_location' => $data['payment_location'] ?? 'online',
                        'price' => $price,
                    ]
                );
            }
        }

        return redirect()->route('rooms.prices.show', $room->id)->with('message', 'Prijzen succesvol bijgewerkt.');
    }
}
