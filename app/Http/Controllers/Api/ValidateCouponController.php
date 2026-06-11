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
        $code = $request->input('coupon_code');

        $coupon = $request->escaperoom->coupons()->where('code', $code)->first();

        if ($coupon) {
            $expired = ($coupon->valid_from && $coupon->valid_from > now())
                || ($coupon->valid_until && $coupon->valid_until < now())
                || ($coupon->usage_limit !== null && $coupon->usage_limit <= 0);

            if ($expired) {
                return response()->json(['valid' => false, 'message' => 'Invalid discount code.']);
            }

            return response()->json(['valid' => true, 'type' => 'coupon', 'coupon' => $coupon]);
        }

        $voucher = $request->escaperoom->giftVouchers()->where('code', $code)->first();

        if ($voucher) {
            if (!$voucher->isActive()) {
                return response()->json(['valid' => false, 'message' => 'This gift voucher is no longer valid.']);
            }

            return response()->json(['valid' => true, 'type' => 'gift_voucher', 'gift_voucher' => [
                'code' => $voucher->code,
                'amount' => $voucher->amount,
            ]]);
        }

        return response()->json(['valid' => false, 'message' => 'Invalid discount code.']);
    }
}
