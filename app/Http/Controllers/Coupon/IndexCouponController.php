<?php

namespace App\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexCouponController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('coupon.index', [
            'coupons' => auth()->user()->escaperoom->coupons()->paginate(10),
        ]);
    }
}
