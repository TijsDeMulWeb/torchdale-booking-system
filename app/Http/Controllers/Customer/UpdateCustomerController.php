<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerOverviewRequest;
use Illuminate\Http\Request;

class UpdateCustomerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreCustomerOverviewRequest $request, int $id)
    {
        $customer = auth()->user()->escaperoom->customers()->findOrFail($id);
        if ($customer->banned_at) {
            abort(403, 'This customer is banned and cannot be edited.');
        }

        $customer->update($request->validated());

        return redirect()->route('customers.show.overview', $customer->id)->with('message', 'Customer updated successfully.');
    }
}
