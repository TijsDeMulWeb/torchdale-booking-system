<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class QuickStoreCustomerController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'first_name'   => 'required|string|max:75',
            'last_name'    => 'required|string|max:75',
            'email'        => 'required|email|max:255',
            'phone'        => 'nullable|string|max:20',
            'street'       => 'nullable|string|max:100',
            'house_number' => 'nullable|string|max:20',
            'postal_code'  => 'nullable|string|max:20',
            'city'         => 'nullable|string|max:100',
            'country'      => 'nullable|string|max:100',
        ]);

        $escaperoomId = auth()->user()->escaperoom_id;

        $customer = Customer::create([
            'escaperoom_id' => $escaperoomId,
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'street'        => $request->street,
            'house_number'  => $request->house_number,
            'postal_code'   => $request->postal_code,
            'city'          => $request->city,
            'country'       => $request->country,
        ]);

        return response()->json([
            'id'    => $customer->id,
            'name'  => $customer->full_name,
            'email' => $customer->email,
            'phone' => $customer->phone,
        ]);
    }
}
