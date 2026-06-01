<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ValidateCouponController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $couponCode = null;
        $couponCode = $request->escaperoom->coupons()->where('code', $request->input('coupon_code'))->first();

        if (!$couponCode) {
            return response()->json(['valid' => false, 'coupon' => $couponCode]);
        }

        return response()->json(['valid' => true, 'coupon' => $couponCode]);
    }
}
