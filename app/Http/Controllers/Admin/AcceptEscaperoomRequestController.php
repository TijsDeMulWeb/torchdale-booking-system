<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\EscaperoomRequestAcceptedMail;
use App\Models\EscaperoomRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AcceptEscaperoomRequestController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, EscaperoomRequest $escaperoomRequest)
    {
        $escaperoom = $escaperoomRequest->escaperoom;
        $publicKey = $escaperoom->apiKeys()->value('public_key');

        if (!$publicKey) {
            return back()->withErrors(['message' => 'Er kon geen API-sleutel gevonden worden voor deze escaperoom, de aanvraag kan niet goedgekeurd worden.']);
        }

        $escaperoomRequest->update([
            'status' => EscaperoomRequest::STATUS_ACCEPTED,
            'reviewed_at' => now(),
        ]);

        Mail::to($escaperoom->email)
            ->send(new EscaperoomRequestAcceptedMail($escaperoom, $publicKey));

        return back()->with('message', 'Aanvraag goedgekeurd. Er is een welkomstmail verstuurd.');
    }
}
