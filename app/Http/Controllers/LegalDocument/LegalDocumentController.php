<?php

namespace App\Http\Controllers\LegalDocument;

use App\Http\Controllers\Controller;
use App\Models\LegalDocument;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LegalDocumentController extends Controller
{
    public function index()
    {
        $escaperoomId = auth()->user()->escaperoom_id;

        $documentsByType = [];
        foreach (LegalDocument::TYPES as $type) {
            $documentsByType[$type] = LegalDocument::where('escaperoom_id', $escaperoomId)
                ->where('type', $type)
                ->orderByDesc('version')
                ->get();
        }

        return view('legalDocuments.index', compact('documentsByType'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => ['required', 'in:' . implode(',', LegalDocument::TYPES)],
            'file' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $escaperoomId = auth()->user()->escaperoom_id;
        $type = $request->input('type');

        $nextVersion = (int) (LegalDocument::where('escaperoom_id', $escaperoomId)
            ->where('type', $type)
            ->max('version')) + 1;

        $path = $request->file('file')->storeAs(
            'escaperooms/' . $escaperoomId . '/legal-documents',
            $type . '-v' . $nextVersion . '.pdf',
            'public'
        );

        LegalDocument::create([
            'escaperoom_id'      => $escaperoomId,
            'type'               => $type,
            'version'            => $nextVersion,
            'file_path'          => $path,
            'original_filename'  => $request->file('file')->getClientOriginalName(),
        ]);

        return redirect()->route('legalDocuments.index')->with('message', __('legalDocuments.upload_success'));
    }

    public function destroy(LegalDocument $legalDocument)
    {
        abort_unless($legalDocument->escaperoom_id === auth()->user()->escaperoom_id, 404);

        $isUsedByOrder = Order::where('privacy_policy_legal_document_id', $legalDocument->id)
            ->orWhere('terms_conditions_legal_document_id', $legalDocument->id)
            ->exists();

        if ($isUsedByOrder) {
            return redirect()->route('legalDocuments.index')->with('message', __('legalDocuments.delete_in_use'));
        }

        Storage::disk('public')->delete($legalDocument->file_path);
        $legalDocument->delete();

        return redirect()->route('legalDocuments.index')->with('message', __('legalDocuments.delete_success'));
    }
}
