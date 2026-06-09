<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequiresMollieKey
{
    public function handle(Request $request, Closure $next): Response
    {
        $setting = auth()->user()?->escaperoom?->escaperoomSetting;

        if (!$setting || !$setting->mollie_api_key) {
            return redirect()
                ->route('escaperoom.edit')
                ->withErrors(['message' => 'Stel eerst een Mollie API-sleutel in voor je bestellingen kan beheren.']);
        }

        return $next($request);
    }
}
