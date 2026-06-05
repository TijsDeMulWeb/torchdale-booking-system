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
        $escaperoomSettings = $request->escaperoom->escaperoomSetting()->first()->only(['widget_color_primary', 'widget_color_primary_dark', 'widget_color_background_dark', 'widget_color_text', 'widget_color_sale', 'widget_color_success']);
        
        return response()->json([
            'success' => true,
            'colors' => [
                'primary' => $escaperoomSettings['widget_color_primary'],
                'primary_dark' => $escaperoomSettings['widget_color_primary_dark'],
                'background_dark' => $escaperoomSettings['widget_color_background_dark'],
                'text' => $escaperoomSettings['widget_color_text'],
                'sale' => $escaperoomSettings['widget_color_sale'],
                'success' => $escaperoomSettings['widget_color_success'],
            ],
        ]);
    }
}
