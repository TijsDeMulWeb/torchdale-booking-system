<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowMessageCustomerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $customer = auth()->user()->escaperoom->customers()->findOrFail($id);

        $mails = $customer->mailLogs()->latest()->get();

        return view('customer.messages', [
            'customer' => $customer,
            'mails'    => $mails,
        ]);
    }
}
