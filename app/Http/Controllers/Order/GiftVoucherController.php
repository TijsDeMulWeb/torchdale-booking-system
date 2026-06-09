<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\GiftVoucher;

class GiftVoucherController extends Controller
{
    public function __invoke()
    {
        $escaperoom   = auth()->user()->escaperoom;
        $escaperoomId = $escaperoom->id;

        $vouchers = GiftVoucher::with(['customer', 'order'])
            ->where('escaperoom_id', $escaperoomId)
            ->latest()
            ->paginate(30);

        $stats = [
            'total'  => GiftVoucher::where('escaperoom_id', $escaperoomId)->count(),
            'active' => GiftVoucher::where('escaperoom_id', $escaperoomId)->where('status', 'active')->count(),
            'used'   => GiftVoucher::where('escaperoom_id', $escaperoomId)->where('status', 'used')->count(),
            'value'  => GiftVoucher::where('escaperoom_id', $escaperoomId)->where('status', 'active')->sum('amount'),
        ];

        return view('order.gift-vouchers', compact('vouchers', 'stats'));
    }
}
