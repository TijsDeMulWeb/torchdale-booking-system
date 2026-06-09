<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\TimeSlot;
class CancelBookingController extends Controller
{
    public function __invoke(TimeSlot $timeSlot)
    {
        $escaperoom = auth()->user()->escaperoom;

        abort_unless(
            $escaperoom->rooms()->where('id', $timeSlot->room_id)->exists(),
            403
        );

        $timeSlot->delete(); // soft delete

        return response()->json(['ok' => true]);
    }
}
