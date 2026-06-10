<?php

namespace App\Console\Commands;

use App\Models\Escaperoom;
use App\Models\TimeSlot;
use App\Services\MailTemplateService;
use Illuminate\Console\Command;

class SendBookingReminders extends Command
{
    protected $signature = 'bookings:send-reminders';

    protected $description = 'Verstuur afspraakherinneringen voor boekingen volgens de per-escaperoom ingestelde "dagen op voorhand"';

    public function handle(MailTemplateService $mailTemplateService): int
    {
        $escaperooms = Escaperoom::whereHas('escaperoomSetting', function ($query) {
            $query->whereNotNull('reminder_days_before')->where('reminder_days_before', '>', 0);
        })->with('escaperoomSetting')->get();

        $sent = 0;

        foreach ($escaperooms as $escaperoom) {
            $daysBefore = $escaperoom->escaperoomSetting->reminder_days_before;
            $targetDate = now()->addDays($daysBefore)->toDateString();

            $timeSlots = TimeSlot::whereNull('reminder_sent_at')
                ->whereHas('room', fn ($query) => $query->where('escaperoom_id', $escaperoom->id))
                ->whereDate('start_time', $targetDate)
                ->with(['room.escaperoomAddress', 'orderedItems.order.customer'])
                ->get();

            foreach ($timeSlots as $timeSlot) {
                $order = $timeSlot->orderedItems->first()?->order;

                if (! $order) {
                    continue;
                }

                $mailTemplateService->sendForRoomReminder($timeSlot, $order);
                $timeSlot->update(['reminder_sent_at' => now()]);
                $sent++;
            }
        }

        $this->info("{$sent} herinneringsmail(s) verstuurd.");

        return self::SUCCESS;
    }
}
