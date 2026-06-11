<?php

namespace App\Http\Controllers\WidgetSettings;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWidgetSettingsRequest;
use Illuminate\Http\Request;

class UpdateWidgetSettingsController extends Controller
{
    public function __invoke(StoreWidgetSettingsRequest $request)
    {
        $data = $request->validated();

        if ($request->has('hear_about_us_options')) {
            $data['hear_about_us_options'] = collect(preg_split('/\r\n|\r|\n/', (string) $data['hear_about_us_options']))
                ->map(fn ($option) => trim($option))
                ->filter()
                ->values()
                ->all();
        }

        if ($request->has('collect_player_names')) {
            $data['collect_player_names'] = $request->boolean('collect_player_names');
        } elseif ($request->has('hear_about_us_options')) {
            $data['collect_player_names'] = false;
        }

        auth()->user()->escaperoom->escaperoomSetting()->update($data);

        return redirect()->route('widgetSettings.show')->with('message', 'Widgetinstellingen opgeslagen.');
    }
}
