<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowAppointmentCustomerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $customer = auth()->user()->escaperoom->customers()->findOrFail($id);
        $appointments = $customer->orders()
            ->where('status', 'paid')
            ->with(['orderedItems.timeSlot.room', 'orderedItems.order'])
            ->get()
            ->flatMap(fn($order) => $order->orderedItems)
            ->filter(fn($item) => $item->time_slot_id !== null)
            ->sortBy('timeSlot.start_time');

        return view('customer.appointments', [
            'customer' => $customer,
            'appointments' => $appointments,
        ]);
    }
}
