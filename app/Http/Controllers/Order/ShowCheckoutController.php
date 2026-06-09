<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;

class ShowCheckoutController extends Controller
{
    public function __invoke()
    {
        return view('order.checkout');
    }
}
