<?php

namespace App\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponRequest;
use Illuminate\Http\Request;

class StoreCouponController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreCouponRequest $request)
    {
        auth()->user()->escaperoom->coupons()->create($request->validated());

        return redirect()->route('coupons.index')->with('message', 'Kortingsbon succesvol toegevoegd.');
    }
}
