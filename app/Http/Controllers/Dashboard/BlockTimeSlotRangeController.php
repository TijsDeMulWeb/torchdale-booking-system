<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlockTimeSlotRangeRequest;
use App\Models\TimeSlot;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BlockTimeSlotRangeController extends Controller
{
    /**
     * The maximum number of calendar days a single bulk-block request may span,
     * to guard against accidentally creating an unbounded number of rows.
     */
    private const MAX_DAYS = 366;

    public function __invoke(BlockTimeSlotRangeRequest $request)
    {
        $data = $request->validated();
        $allDay = $request->boolean('all_day');

        $room = $request->user()->escaperoom->rooms()->findOrFail($data['room_id']);

        $startDate = Carbon::parse($data['start_date'])->startOfDay();
        $endDate = Carbon::parse($data['end_date'])->startOfDay();

        if ($startDate->diffInDays($endDate) + 1 > self::MAX_DAYS) {
            return back()->withErrors(['message' => 'Die periode is te lang — kies een periode van maximaal '.self::MAX_DAYS.' dagen.']);
        }

        // Build the desired [start, end) block range for every day in the period.
        $ranges = [];
        $cursor = $startDate->copy();

        while ($cursor->lessThanOrEqualTo($endDate)) {
            if ($allDay) {
                $start = $cursor->copy();
                $end = $cursor->copy()->addDay();
            } else {
                $start = Carbon::parse("{$cursor->toDateString()} {$data['start']}");
                $end = Carbon::parse("{$cursor->toDateString()} {$data['end']}");

                if ($end->lessThanOrEqualTo($start)) {
                    $end->addDay();
                }
            }

            $ranges[] = [$start, $end];
            $cursor->addDay();
        }

        // Fetch every existing time slot (booking or block) that overlaps the
        // overall period in one query — the per-day ranges are chronological,
        // so the first range's start and the last range's end bound them all.
        $overallStart = $ranges[0][0];
        $overallEnd = $ranges[count($ranges) - 1][1];

        $existing = TimeSlot::where('room_id', $room->id)
            ->where('start_time', '<', $overallEnd)
            ->where('end_time', '>', $overallStart)
            ->orderBy('start_time')
            ->get(['id', 'start_time', 'end_time']);

        // For each day, "carve out" any existing bookings/blocks from the
        // desired range and only keep the remaining free gaps — so a period
        // block doesn't get rejected (or skip an entire day) just because
        // part of that day is already taken. Existing bookings and blocks are
        // left untouched; we simply don't create new rows where they already are.
        $toCreate = [];
        $daysWithConflicts = 0;

        foreach ($ranges as [$start, $end]) {
            $overlaps = $existing->filter(
                fn (TimeSlot $slot) => $slot->start_time->lessThan($end) && $slot->end_time->greaterThan($start)
            )->values();

            if ($overlaps->isEmpty()) {
                $toCreate[] = [$start->copy(), $end->copy()];
                continue;
            }

            $daysWithConflicts++;
            $gapCursor = $start->copy();

            foreach ($overlaps as $slot) {
                $slotStart = $slot->start_time->greaterThan($start) ? $slot->start_time->copy() : $start->copy();
                $slotEnd = $slot->end_time->lessThan($end) ? $slot->end_time->copy() : $end->copy();

                if ($gapCursor->lessThan($slotStart)) {
                    $toCreate[] = [$gapCursor->copy(), $slotStart->copy()];
                }

                if ($slotEnd->greaterThan($gapCursor)) {
                    $gapCursor = $slotEnd->copy();
                }
            }

            if ($gapCursor->lessThan($end)) {
                $toCreate[] = [$gapCursor->copy(), $end->copy()];
            }
        }

        if (empty($toCreate)) {
            return back()->withErrors(['message' => 'Er kon niets worden geblokkeerd: de volledige periode overlapt al met bestaande boekingen of blokkades.']);
        }

        DB::transaction(function () use ($toCreate, $room, $data) {
            foreach ($toCreate as [$start, $end]) {
                TimeSlot::create([
                    'room_id' => $room->id,
                    'start_time' => $start,
                    'end_time' => $end,
                    'blocked_at' => now(),
                    'blocked_reason' => $data['reason'] ?? null,
                ]);
            }
        });

        $message = count($toCreate).' tijdslot(en) geblokkeerd.';

        if ($daysWithConflicts > 0) {
            $message .= ' Bij '.$daysWithConflicts.' dag(en) is er rond bestaande boekingen of blokkades heen geblokkeerd.';
        }

        return back()->with('message', $message);
    }
}
