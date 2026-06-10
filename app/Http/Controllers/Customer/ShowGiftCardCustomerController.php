<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowGiftCardCustomerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $customer = auth()->user()->escaperoom->customers()->findOrFail($id);

        $vouchers = $customer->giftVouchers()->with('giftCard')->latest()->get();

        return view('customer.giftCards', [
            'customer' => $customer,
            'vouchers' => $vouchers,
        ]);
    }
}
