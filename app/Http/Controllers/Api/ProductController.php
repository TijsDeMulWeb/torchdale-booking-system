<?php

namespace App\Http\Controllers\Api;

use App\Models\EscaperoomSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $products = $request->escaperoom->products()->get();

        return response()->json(['success' => true, 'products' => $products]);
    }
}
