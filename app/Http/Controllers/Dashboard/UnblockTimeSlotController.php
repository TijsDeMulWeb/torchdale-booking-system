<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\TimeSlot;
use Illuminate\Http\Request;

class UnblockTimeSlotController extends Controller
{
    public function __invoke(Request $request, TimeSlot $timeSlot)
    {
        $roomIds = $request->user()->escaperoom->rooms()->pluck('id');

        if (!$timeSlot->blocked_at || !$roomIds->contains($timeSlot->room_id)) {
            abort(404);
        }

        $timeSlot->delete();

        return back()->with('message', 'Tijdslot gedeblokkeerd.');
    }
}
