<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OpenOrdersController extends Controller
{
    public function __invoke(Request $request)
    {
        $escaperoomId = auth()->user()->escaperoom_id;

        $orders = Order::with('customer', 'invoice')
            ->where('escaperoom_id', $escaperoomId)
            ->where('status', 'pending')
            ->whereNotNull('payment_method')
            ->orderByDesc('created_at')
            ->paginate(30);

        $stats = [
            'count'  => Order::where('escaperoom_id', $escaperoomId)->where('status', 'pending')->whereNotNull('payment_method')->count(),
            'total'  => Order::where('escaperoom_id', $escaperoomId)->where('status', 'pending')->whereNotNull('payment_method')->sum('total'),
            'online' => Order::where('escaperoom_id', $escaperoomId)->where('status', 'pending')->where('payment_method', 'online')->count(),
        ];

        return view('order.openOrders', compact('orders', 'stats'));
    }
}
