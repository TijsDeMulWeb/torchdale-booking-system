<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\GiftVoucher;
use App\Services\GiftVoucherService;
use Illuminate\Http\Request;

class StoreManualGiftVoucherController extends Controller
{
    public function __invoke(Request $request, GiftVoucherService $service)
    {
        $data = $request->validate([
            'amount'          => ['required', 'numeric', 'min:1', 'max:9999.99'],
            'valid_until'     => ['nullable', 'date', 'after:today'],
            'delivery_method' => ['required', 'in:mail,post,pickup'],
            'shipping_cost'   => ['nullable', 'numeric', 'min:0', 'max:99.99'],
        ]);

        $escaperoom = auth()->user()->escaperoom;

        $shippingCost = ($data['delivery_method'] === 'post')
            ? round((float) ($data['shipping_cost'] ?? 0), 2)
            : 0;

        GiftVoucher::create([
            'escaperoom_id'   => $escaperoom->id,
            'code'            => $service->generateCode(),
            'amount'          => round((float) $data['amount'], 2),
            'source'          => 'manual',
            'delivery_method' => $data['delivery_method'],
            'shipping_cost'   => $shippingCost,
            'status'          => 'active',
            'valid_until'     => !empty($data['valid_until']) ? $data['valid_until'] : now()->addYear(),
        ]);

        return redirect()->route('orders.gift-vouchers')->with('success', 'Cadeaubon aangemaakt.');
    }
}
