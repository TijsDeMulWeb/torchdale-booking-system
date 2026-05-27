<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;

class StoreLoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        $response = RateLimiter::attempt(
            'login:' . $request->ip(),
            $perMinute = 5,
            function () use ($request) {
                if (Auth::attempt($request->validated())) {
                    $request->session()->regenerate();
                    return redirect()->route('dashboard.show');
                }

                return back()->withErrors([
                    'email' => 'The provided credentials do not match'
                ]);
            }
        );

        if (!$response) {
            return back()->withErrors([
                'email' => trans('auth.throttle', [
                    'seconds' => RateLimiter::availableIn('login:' . $request->ip()),
                ])
            ]);
        }

        return $response;
    }
}
