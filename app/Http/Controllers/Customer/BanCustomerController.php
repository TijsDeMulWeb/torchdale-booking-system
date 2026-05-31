<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BanCustomerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $customer = auth()->user()->escaperoom->customers()->findOrFail($id);
        $customer->update(['banned_at' => now()]);
        return redirect()->route('customers.show.overview', $id)->with('message', 'Customer has been banned successfully.');
    }
}
