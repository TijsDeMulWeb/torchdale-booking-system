<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RoomAvailabilityController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $room)
    {
        $room = $request->escaperoom->rooms()->find($room);

        if (!$room) {
            return response()->json(['success' => false, 'message' => 'Room not found.'], 404);
        }

        $from = $request->filled('from') ? Carbon::parse($request->input('from'))->startOfDay() : now()->startOfDay();
        $to = $request->filled('to') ? Carbon::parse($request->input('to'))->endOfDay() : $from->copy()->addDays(90)->endOfDay();

        $bookedSlots = TimeSlot::where('room_id', $room->id)
            ->whereBetween('start_time', [$from, $to])
            ->get(['start_time', 'end_time'])
            ->map(fn (TimeSlot $slot) => [
                'date' => $slot->start_time->toDateString(),
                'start_time' => $slot->start_time->format('H:i:s'),
                'end_time' => $slot->end_time->format('H:i:s'),
            ])
            ->values();

        return response()->json(['success' => true, 'booked_slots' => $bookedSlots]);
    }
}
