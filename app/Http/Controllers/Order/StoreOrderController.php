<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreOrderController extends Controller
{
    public function __invoke(Request $request)
    {
        dd($request->all());
    }
}
