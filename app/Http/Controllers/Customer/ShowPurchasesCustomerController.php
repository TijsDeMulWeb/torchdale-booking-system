<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowPurchasesCustomerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $customer = auth()->user()->escaperoom->customers()->findOrFail($id);
        $orders = $customer->orders()->with([
            'escaperoom',
            'orderedItems.timeSlot.room',
            'orderedItems.giftCard',
            'orderedItems.product',
        ])->latest()->paginate(10);

        return view('customer.purchases', [
            'customer' => $customer,
            'orders' => $orders,
        ]);
    }
}
