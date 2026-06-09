<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\GiftVoucher;
use Illuminate\Http\Request;

class UpdateGiftVoucherDeliveryController extends Controller
{
    public function __invoke(Request $request, GiftVoucher $voucher)
    {
        abort_if($voucher->escaperoom_id !== auth()->user()->escaperoom_id, 403);

        $data = $request->validate([
            'delivery_method' => ['required', 'in:mail,post,pickup'],
            'shipping_cost'   => ['nullable', 'numeric', 'min:0', 'max:99.99'],
        ]);

        $voucher->update([
            'delivery_method' => $data['delivery_method'],
            'shipping_cost'   => $data['delivery_method'] === 'post'
                ? round((float) ($data['shipping_cost'] ?? 0), 2)
                : 0,
        ]);

        return back()->with('success', 'Leveringswijze bijgewerkt.');
    }
}
