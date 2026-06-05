<?php

namespace App\Http\Controllers\WidgetSettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowWidgetSettingsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $widgetSettings = auth()->user()->escaperoom->escaperoomSetting()->first()->only(['widget_color_primary', 'widget_color_primary_dark', 'widget_color_background_dark', 'widget_color_text', 'widget_color_sale', 'widget_color_success']);
        $apiKey = auth()->user()->escaperoom->apiKeys()->where('name', 'LIKE', '%Default%')->first();
        return view('widgetSettings.show', [
            'widgetSettings' => $widgetSettings,
            'apiKey' => $apiKey,
        ]);
    }
}
