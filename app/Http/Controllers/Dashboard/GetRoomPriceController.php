<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class GetRoomPriceController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'room_id' => 'required|integer',
            'date'    => 'required|date_format:Y-m-d',
            'players' => 'required|integer|min:1',
        ]);

        $escaperoom = $request->user()->escaperoom;
        $room = $escaperoom->rooms()->find($request->room_id);

        if (!$room) {
            return response()->json(['found' => false]);
        }

        $dayOfWeek = Carbon::parse($request->date)->dayOfWeekIso - 1; // 0=Mon … 6=Sun

        $price = $room->prices()
            ->where('day_of_week', $dayOfWeek)
            ->where('player_amount', $request->players)
            ->first();

        if (!$price) {
            return response()->json(['found' => false, 'day_of_week' => $dayOfWeek, 'players' => $request->players]);
        }

        return response()->json([
            'found'          => true,
            'price'          => $price->price,
            'vat_percentage' => $price->vat_percentage,
            'payment_location' => $price->payment_location,
        ]);
    }
}
