<?php

namespace App\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponRequest;

class UpdateCouponController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreCouponRequest $request, int $id)
    {
        $coupon = auth()->user()->escaperoom->coupons()->findOrFail($id);

        abort_if($coupon->escaperoom_id !== auth()->user()->escaperoom_id, 403);

        $coupon->update($request->validated());

        return redirect()->route('coupons.index')->with('message', 'Kortingsbon updated successfully.');
    }
}
