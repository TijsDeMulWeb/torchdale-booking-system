<?php

namespace App\Http\Middleware;

use App\Models\EscaperoomSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateEscaperoom
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('applicationKey');

        if (!$apiKey) {
            return response()->json(['message' => 'API key is missing'], 401);
        }

        $escaperoomSetting = EscaperoomSetting::where('escaperoom_api_key_hash', hash('sha256', $apiKey))->first();

        if (!$escaperoomSetting) {
            return response()->json(['message' => 'Invalid API key'], 401);
        }

        $request->merge(['escaperoom' => $escaperoomSetting->escaperoom]);

        return $next($request);
    }
}
