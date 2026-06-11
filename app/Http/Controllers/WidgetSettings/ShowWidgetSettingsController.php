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
        $escaperoom = auth()->user()->escaperoom;

        $escaperoomSetting = $escaperoom->escaperoomSetting()->first();

        $widgetSettings = $escaperoomSetting->only([
            'widget_color_primary',
            'widget_color_primary_dark',
            'widget_color_background_dark',
            'widget_color_text',
            'widget_color_sale',
            'widget_color_success',
        ]);

        $bookingSettings = $escaperoomSetting->only([
            'hear_about_us_options',
            'collect_player_names',
        ]);

        $defaultApiKey = $escaperoom->apiKeys()
            ->where('name', 'Default API Key')
            ->first();

        $apiKeys = $escaperoom->apiKeys()
            ->where('is_active', true)
            ->where('name', '!=', 'Default API Key')
            ->orderBy('name')
            ->get();

        return view('widgetSettings.show', [
            'widgetSettings' => $widgetSettings,
            'bookingSettings' => $bookingSettings,
            'apiKeys' => $apiKeys,
            'defaultApiKey' => $defaultApiKey,
        ]);
    }
}
