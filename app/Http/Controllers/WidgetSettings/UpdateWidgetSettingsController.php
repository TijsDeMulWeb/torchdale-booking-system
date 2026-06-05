<?php

namespace App\Http\Controllers\WidgetSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWidgetSettingsRequest;
use Illuminate\Http\Request;

class UpdateWidgetSettingsController extends Controller
{
    public function __invoke(StoreWidgetSettingsRequest $request)
    {
        auth()->user()->escaperoom->escaperoomSetting()->update($request->validated());

        return redirect()->route('widgetSettings.show')->with('message', 'Widgetkleuren opgeslagen.');
    }
}
