<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnblockTimeSlotRangeRequest;
use App\Models\TimeSlot;
use Illuminate\Support\Carbon;

class UnblockTimeSlotRangeController extends Controller
{
    /**
     * Removes every blocked time slot for a room that overlaps the given date
     * range — letting the user undo a bulk block (e.g. a month-long closure)
     * in one go instead of unblocking each day individually. Only rows with
     * `blocked_at` set are affected; real bookings are never touched.
     */
    public function __invoke(UnblockTimeSlotRangeRequest $request)
    {
        $data = $request->validated();

        $room = $request->user()->escaperoom->rooms()->findOrFail($data['room_id']);

        $rangeStart = Carbon::parse($data['start_date'])->startOfDay();
        $rangeEnd = Carbon::parse($data['end_date'])->startOfDay()->addDay();

        $query = TimeSlot::query()
            ->where('room_id', $room->id)
            ->whereNotNull('blocked_at')
            ->where('start_time', '<', $rangeEnd)
            ->where('end_time', '>', $rangeStart);

        $count = $query->count();

        if ($count === 0) {
            return back()->withErrors(['message' => 'Er zijn geen geblokkeerde tijdsloten gevonden in deze periode voor deze kamer.']);
        }

        $query->delete();

        return back()->with('message', "{$count} geblokkeerde tijdslot(en) gedeblokkeerd.");
    }
}
