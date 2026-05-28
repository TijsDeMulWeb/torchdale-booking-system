<?php

namespace App\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditCouponController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        return view('coupon.edit', [
            'coupon' => auth()->user()->escaperoom->coupons()->findOrFail($request->id),
        ]);
    }
}
