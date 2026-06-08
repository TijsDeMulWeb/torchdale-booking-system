<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;

class StoreAdminLoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $response = RateLimiter::attempt(
            'login:' . $request->ip(),
            $perMinute = 5,
            function () use ($request) {
                $admin = Admin::where('email', $request->email)->first();

                if ($admin && Hash::check($request->password, $admin->password)) {
                    Auth::guard('admin')->login($admin);
                    $request->session()->regenerate();
                    return redirect()->route('admin.dashboard.show');
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