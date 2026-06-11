<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LegalDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LegalDocumentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $escaperoom = $request->escaperoom;

        $documents = collect(LegalDocument::TYPES)->mapWithKeys(function (string $type) use ($escaperoom) {
            $document = $escaperoom->latestLegalDocument($type);

            return [$type => $document ? [
                'version' => $document->version,
                'url' => Storage::disk('public')->url($document->file_path),
            ] : null];
        });

        return response()->json([
            'success' => true,
            'privacy_policy' => $documents[LegalDocument::TYPE_PRIVACY_POLICY],
            'terms_conditions' => $documents[LegalDocument::TYPE_TERMS_CONDITIONS],
        ]);
    }
}
