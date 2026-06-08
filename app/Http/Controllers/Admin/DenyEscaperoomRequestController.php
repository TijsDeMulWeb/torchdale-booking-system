<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\EscaperoomRequestDeniedMail;
use App\Models\EscaperoomRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DenyEscaperoomRequestController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, EscaperoomRequest $escaperoomRequest)
    {
        $escaperoomRequest->update([
            'status' => EscaperoomRequest::STATUS_DENIED,
            'reviewed_at' => now(),
        ]);

        Mail::to($escaperoomRequest->escaperoom->email)
            ->send(new EscaperoomRequestDeniedMail($escaperoomRequest->escaperoom));

        return back()->with('message', 'Aanvraag geweigerd. Er is een mail verstuurd.');
    }
}
