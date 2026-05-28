<?php

namespace App\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteCouponController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $coupon = auth()->user()->escaperoom->coupons()->findOrFail($id);
        abort_if($coupon->escaperoom_id !== auth()->user()->escaperoom_id, 403);

        $coupon->delete();

        return redirect()->route('coupons.index')->with('message', 'Kortingsbon deleted successfully.');
    }
}
