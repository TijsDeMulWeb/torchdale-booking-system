<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlockTimeSlotRequest;
use App\Models\TimeSlot;
use Illuminate\Support\Carbon;

class BlockTimeSlotController extends Controller
{
    public function __invoke(BlockTimeSlotRequest $request)
    {
        $data = $request->validated();

        $room = $request->user()->escaperoom->rooms()->findOrFail($data['room_id']);

        $start = Carbon::parse("{$data['date']} {$data['start']}");
        $end = Carbon::parse("{$data['date']} {$data['end']}");

        if ($end->lessThanOrEqualTo($start)) {
            $end->addDay();
        }

        $hasConflict = TimeSlot::where('room_id', $room->id)
            ->where('start_time', '<', $end)
            ->where('end_time', '>', $start)
            ->exists();

        if ($hasConflict) {
            return back()->withErrors(['message' => 'Dit tijdslot is ondertussen al bezet of geblokkeerd.']);
        }

        TimeSlot::create([
            'room_id' => $room->id,
            'start_time' => $start,
            'end_time' => $end,
            'blocked_at' => now(),
            'blocked_reason' => $data['reason'] ?? null,
        ]);

        return back()->with('message', 'Tijdslot geblokkeerd.');
    }
}
