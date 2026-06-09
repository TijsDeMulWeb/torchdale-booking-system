<?php

namespace App\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class SearchCouponController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (strlen($query) < 1) {
            return response()->json([]);
        }

        $escaperoomId = auth()->user()->escaperoom_id;

        $coupons = Coupon::where('escaperoom_id', $escaperoomId)
            ->where(function ($q) use ($query) {
                $q->where('code', 'like', "%{$query}%")
                  ->orWhere('name', 'like', "%{$query}%");
            })
            ->limit(8)
            ->get();

        return response()->json($coupons->map(fn($c) => [
            'id'             => $c->id,
            'name'           => $c->name,
            'code'           => $c->code,
            'discount_type'  => $c->discount_type,
            'discount_value' => $c->discount_value,
            'valid_from'     => $c->valid_from?->toDateString(),
            'valid_until'    => $c->valid_until?->toDateString(),
            'usage_limit'    => $c->usage_limit,
            'times_used'     => $c->times_used,
        ]));
    }
}
