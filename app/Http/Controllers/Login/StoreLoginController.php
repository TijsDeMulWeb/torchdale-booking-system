<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreLoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();

            session([
                'first_name' => Auth::user()->first_name,
                'last_name' => Auth::user()->last_name,
                'profile_picture' => Auth::user()->profile_picture,
            ]);

            return redirect()->route('dashboard.show');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match'
        ]);
    }
}
