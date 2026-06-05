<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use App\Models\EscaperoomSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateEscaperoom
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->secure() && app()->environment('production')) {
            return response()->json(['message' => 'HTTPS required'], 403);
        }

        $publicKey = $request->header('X-API-Public-Key');

        if (!$publicKey) {
            return response()->json(['message' => 'API key missing'], 401);
        }

        $rateLimitKey = 'api:' . $request->ip();
        if (RateLimiter::tooManyAttempts($rateLimitKey, 60)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return response()->json([
                'message'     => 'Too many requests',
                'retry_after' => $seconds,
            ], 429);
        }
        RateLimiter::hit($rateLimitKey, 60);

        $apiKey = ApiKey::where('public_key', $publicKey)->first();
        return response()->json(['message' => $apiKey], 401);

        if (!$apiKey || !$apiKey->is_active) {
            Log::warning('Invalid API key attempt', [
                'ip'         => $request->ip(),
                'public_key' => $publicKey,
                'origin'     => $request->header('Origin'),
            ]);
            return response()->json(['message' => 'Invalid API key'], 401);
        }

        // Origin check
        $origin = $request->header('Origin');
        if ($apiKey->allowed_origin && $origin !== $apiKey->allowed_origin) {
            return response()->json(['message' => 'Origin not allowed'], 403);
        }

        $request->merge(['escaperoom' => $apiKey->escaperoom]);

        return $next($request);
    }
}