<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\RoomTimeSlot;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ShowDashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $view = $request->get('view') === 'week' ? 'week' : 'day';
        $date = $request->date('date') ?? Carbon::today();

        $weekStart = $date->copy()->startOfWeek();
        $weekEnd = $date->copy()->endOfWeek();

        $rooms = $request->user()->escaperoom->rooms()->orderBy('name')->get();
        $roomIds = $rooms->pluck('id');

        $weekDays = collect(range(0, 6))->map(function (int $offset) use ($weekStart) {
            $day = $weekStart->copy()->addDays($offset);

            return [
                'date' => $day->toDateString(),
                'label' => ucfirst($day->translatedFormat('D j M')),
                'isToday' => $day->isToday(),
            ];
        })->values();

        $events = $rooms->isNotEmpty()
            ? $this->buildWeekEvents($rooms, $weekStart, $weekEnd, $weekDays)
            : collect();

        $dayLabel = ucfirst($date->translatedFormat('l j F Y'));
        $weekLabel = ucfirst($weekStart->translatedFormat('j M')).' – '.ucfirst($weekEnd->translatedFormat('j M Y'));

        return view('dashboard', [
            'rooms' => $rooms,
            'view' => $view,
            'periodLabel' => $view === 'week' ? $weekLabel : $dayLabel,
            'calendarData' => [
                'baseUrl' => route('dashboard.show'),
                'today' => Carbon::today()->toDateString(),
                'date' => $date->toDateString(),
                'view' => $view,
                'dayLabel' => $dayLabel,
                'weekLabel' => $weekLabel,
                'weekDays' => $weekDays,
                'rooms' => $rooms->map(fn ($room) => [
                    'id' => $room->id,
                    'name' => $room->name,
                    'color' => $room->color ?? '#6366f1',
                    'minPlayers' => $room->min_players,
                    'maxPlayers' => $room->max_players,
                ])->values(),
                'events' => $events,
            ],
        ]);
    }

    /**
     * Builds the week's calendar events by overlaying actual bookings onto the
     * rooms' weekly availability templates: each template slot shows as an
     * "available" placeholder unless a booking matches it exactly (by room,
     * date and time), in which case the booking replaces it. Bookings that
     * don't match any template slot are still shown as standalone "free" events.
     *
     * "Available" placeholders additionally respect each room's booking window
     * (min/max booking advance, in days, measured from today at midnight):
     * a slot only shows as bookable if its date falls within
     * [today + min_booking_advance, today + max_booking_advance]. Actual
     * bookings (and blocked slots) are never hidden by this window.
     *
     * @param  \Illuminate\Support\Collection<int, \App\Models\Room>  $rooms
     * @param  \Illuminate\Support\Collection<int, array{date: string, label: string, isToday: bool}>  $weekDays
     * @return \Illuminate\Support\Collection<int, array>
     */
    private function buildWeekEvents($rooms, Carbon $weekStart, Carbon $weekEnd, $weekDays)
    {
        $roomIds = $rooms->pluck('id');
        $today = Carbon::today();

        $bookingWindows = $rooms->mapWithKeys(function ($room) use ($today) {
            return [$room->id => [
                'earliest' => $today->copy()->addDays($room->min_booking_advance ?? 0),
                'latest' => $room->max_booking_advance !== null
                    ? $today->copy()->addDays($room->max_booking_advance)
                    : null,
            ]];
        });

        $templatesByRoomAndDay = RoomTimeSlot::query()
            ->whereIn('room_id', $roomIds)
            ->get()
            ->groupBy(['room_id', 'day_of_week']);

        $bookings = TimeSlot::query()
            ->whereIn('room_id', $roomIds)
            ->where('start_time', '<', $weekEnd->copy()->endOfDay())
            ->where('end_time', '>', $weekStart->copy()->startOfDay())
            ->with('orderedItems.order.customer')
            ->get();

        $bookingsByRoom = $bookings->groupBy('room_id');

        $consumedIds = [];
        $events = collect();

        foreach ($weekDays as $day) {
            $dayOfWeek = Carbon::parse($day['date'])->dayOfWeekIso - 1;

            foreach ($roomIds as $roomId) {
                $templates = $templatesByRoomAndDay->get($roomId, collect())->get($dayOfWeek, collect());
                $roomBookings = $bookingsByRoom->get($roomId, collect());

                foreach ($templates as $template) {
                    $start = $template->start_time->format('H:i');
                    $end = $template->end_time->format('H:i');

                    $templateStart = Carbon::parse("{$day['date']} {$start}");
                    $templateEnd = Carbon::parse("{$day['date']} {$end}");

                    if ($templateEnd->lessThanOrEqualTo($templateStart)) {
                        $templateEnd->addDay();
                    }

                    // A template slot is "taken over" by an actual booking/block when
                    // their times match exactly — in that case we show the booking's
                    // details in place of the placeholder. When an actual booking/block
                    // merely overlaps the template slot without matching it exactly
                    // (e.g. a full-day block covering several template slots, or a
                    // booking that runs longer than its template), the slot is no
                    // longer truly available, so the "Beschikbaar" placeholder is
                    // suppressed entirely — the overlapping booking/block is rendered
                    // separately by the loop below.
                    $exactMatch = $roomBookings->first(
                        fn (TimeSlot $timeSlot) => $timeSlot->start_time->equalTo($templateStart) && $timeSlot->end_time->equalTo($templateEnd)
                    );

                    if ($exactMatch) {
                        $consumedIds[$exactMatch->id] = true;
                        [$title, $blocked] = $this->describeBooking($exactMatch);
                        $booked = true;
                        $timeSlotId = $exactMatch->id;
                    } else {
                        $hasOverlap = $roomBookings->contains(
                            fn (TimeSlot $timeSlot) => $timeSlot->start_time->lessThan($templateEnd) && $timeSlot->end_time->greaterThan($templateStart)
                        );

                        if ($hasOverlap) {
                            continue;
                        }

                        $title = 'Beschikbaar';
                        $blocked = false;
                        $booked = false;
                        $timeSlotId = null;
                    }

                    // A template slot that runs past midnight (e.g. 23:00 - 01:00) is split
                    // into one segment per calendar day, so it stays visible on each of those days.
                    foreach ($this->splitByCalendarDay($templateStart, $templateEnd) as $index => $segment) {
                        // "Available" placeholders are hidden outside the room's booking
                        // window (min/max booking advance). Real bookings and blocked
                        // slots always show, regardless of this window.
                        if (!$booked && !$this->isWithinBookingWindow($segment['date'], $bookingWindows[$roomId])) {
                            continue;
                        }

                        $events->push([
                            'id' => "template-{$template->id}-{$day['date']}-{$index}",
                            'roomId' => $roomId,
                            'date' => $segment['date'],
                            'start' => $segment['start'],
                            'end' => $segment['end'],
                            'title' => $title,
                            'booked' => $booked,
                            'blocked' => $blocked,
                            'timeSlotId' => $timeSlotId,
                        ]);
                    }
                }
            }
        }

        foreach ($bookings as $booking) {
            if (isset($consumedIds[$booking->id])) {
                continue;
            }

            [$title, $blocked] = $this->describeBooking($booking);

            // A booking that runs past midnight (e.g. 23:00 - 01:00) is split into
            // one segment per calendar day, so it remains visible on each of those days.
            foreach ($this->splitByCalendarDay($booking->start_time, $booking->end_time) as $index => $segment) {
                $events->push([
                    'id' => "booking-{$booking->id}-{$index}",
                    'roomId' => $booking->room_id,
                    'date' => $segment['date'],
                    'start' => $segment['start'],
                    'end' => $segment['end'],
                    'title' => $title,
                    'booked' => true,
                    'blocked' => $blocked,
                    'timeSlotId' => $booking->id,
                ]);
            }
        }

        return $events->values();
    }

    /**
     * Determines whether a given calendar date falls within a room's booking
     * window — i.e. between `today + min_booking_advance` (inclusive) and,
     * when set, `today + max_booking_advance` (inclusive). Both bounds are
     * evaluated at calendar-date (midnight) granularity.
     *
     * @param  array{earliest: \Illuminate\Support\Carbon, latest: ?\Illuminate\Support\Carbon}  $window
     */
    private function isWithinBookingWindow(string $date, array $window): bool
    {
        $segmentDate = Carbon::parse($date);

        if ($segmentDate->lessThan($window['earliest'])) {
            return false;
        }

        if ($window['latest'] !== null && $segmentDate->greaterThan($window['latest'])) {
            return false;
        }

        return true;
    }

    /**
     * Resolves the display title and "blocked" flag for an actual booking:
     * blocked slots show their reason (or a generic label), real bookings show
     * the customer's name, falling back to a generic label when neither applies.
     *
     * @return array{0: string, 1: bool}
     */
    private function describeBooking(TimeSlot $booking): array
    {
        if ($booking->blocked_at) {
            return [$booking->blocked_reason ?: 'Geblokkeerd', true];
        }

        $customer = $booking->orderedItems->first()?->order?->customer;

        return [$customer?->full_name ?? 'Geboekt', false];
    }

    /**
     * Splits a [start, end) range into one segment per calendar day it touches,
     * so a booking that crosses midnight (e.g. 23:00 - 01:00) shows up on both
     * the day it starts and the day it ends, clipped to that day's boundaries.
     *
     * @return array<int, array{date: string, start: string, end: string}>
     */
    private function splitByCalendarDay(Carbon $start, Carbon $end): array
    {
        $segments = [];
        $cursor = $start->copy();

        while ($cursor->lt($end)) {
            $nextMidnight = $cursor->copy()->addDay()->startOfDay();
            $segmentEnd = $end->lessThan($nextMidnight) ? $end->copy() : $nextMidnight;

            $segments[] = [
                'date' => $cursor->toDateString(),
                'start' => $cursor->format('H:i'),
                'end' => $segmentEnd->isSameDay($cursor) ? $segmentEnd->format('H:i') : '24:00',
            ];

            $cursor = $segmentEnd;
        }

        return $segments;
    }
}
