<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WidgetConfigController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return response()->json([
            'success' => true,
            'colors' => [
                'primary' => '#ed6e0c',
                'primary_dark' => '#b8560a',
                'background_dark' => '#1f2445',
                'text' => '#1f2445',
                'sale' => '#e74c3c',
                'success' => '#27ae60',
            ],
        ]);
    }
}
