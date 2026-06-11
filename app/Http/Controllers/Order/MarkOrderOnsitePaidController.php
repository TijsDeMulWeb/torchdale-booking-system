<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;

class MarkOrderOnsitePaidController extends Controller
{
    public function __invoke(Order $order): RedirectResponse
    {
        abort_unless($order->escaperoom_id === auth()->user()->escaperoom_id, 404);

        $order->amount_paid_onsite = $order->amount_onsite;

        if (((float) $order->amount_paid_online + (float) $order->amount_paid_onsite) >= (float) $order->total) {
            $order->status = 'paid';
        }

        $order->save();

        return back()->with('success', __('orders.onsite_payment_marked'));
    }
}
