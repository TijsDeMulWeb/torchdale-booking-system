<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class SearchCustomerController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $escaperoomId = auth()->user()->escaperoom_id;

        $customers = Customer::where('escaperoom_id', $escaperoomId)
            ->where(function ($q) use ($query) {
                $q->where('first_name', 'like', "%{$query}%")
                  ->orWhere('last_name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%{$query}%"]);
            })
            ->limit(8)
            ->get(['id', 'first_name', 'last_name', 'email', 'phone', 'country']);

        return response()->json($customers->map(fn($c) => [
            'id'         => $c->id,
            'name'       => $c->full_name,
            'email'      => $c->email,
            'phone'      => $c->phone,
            'country_iso' => $c->country ?? null,
        ]));
    }
}
