<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexCustomerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $customers = auth()->user()->escaperoom->customers()->paginate(10);

        return view('customer.index', [
            'customers' => $customers,
        ]);
    }
}
