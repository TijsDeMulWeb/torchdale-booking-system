<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EscaperoomRequest;
use Illuminate\Http\Request;

class ShowAdminDashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $requests = EscaperoomRequest::with('escaperoom')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.dashboard', [
            'requests' => $requests,
        ]);
    }
}
