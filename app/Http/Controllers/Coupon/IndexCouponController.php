<?php

namespace App\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class IndexCouponController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $coupons = auth()->user()->escaperoom
            ->coupons()
            ->when($request->search, function ($query) use ($request) {
                $query->where('code', 'like', '%' . $request->search . '%');
            })
            ->paginate(10)
            ->withQueryString();

        return view('coupon.index', [
            'coupons' => $coupons,
        ]);
    }
}