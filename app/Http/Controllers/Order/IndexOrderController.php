<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class IndexOrderController extends Controller
{
    public function __invoke(Request $request)
    {
        $escaperoomId = auth()->user()->escaperoom_id;

        $todayOrders = Order::with(['customer', 'orderedItems', 'invoice'])
            ->where('escaperoom_id', $escaperoomId)
            ->whereDate('created_at', today())
            ->latest()
            ->paginate(20);

        $orders = Order::with(['customer', 'orderedItems', 'invoice'])
            ->where('escaperoom_id', $escaperoomId)
            ->whereDate('created_at', '!=', today())
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $todayRevenue = Order::where('escaperoom_id', $escaperoomId)
            ->where('status', 'paid')
            ->whereDate('created_at', today())
            ->sum('total');

        $totalRevenue = Order::where('escaperoom_id', $escaperoomId)
            ->where('status', 'paid')
            ->sum('total');

        $todayOrderCount = $todayOrders->total();
        $totalOrderCount = Order::where('escaperoom_id', $escaperoomId)->count();

        return view('order.index', compact(
            'todayOrders',
            'orders',
            'todayRevenue',
            'totalRevenue',
            'todayOrderCount',
            'totalOrderCount',
        ));
    }
}
