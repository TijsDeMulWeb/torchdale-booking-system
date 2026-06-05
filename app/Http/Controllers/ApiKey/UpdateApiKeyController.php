<?php

namespace App\Http\Controllers\ApiKey;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateApiKeyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $apiKey = auth()->user()->escaperoom->apiKeys()->findOrFail($id);

        $request->validate([
            'is_active' => ['required', 'boolean']
        ]);

        $apiKey->update([
            'is_active' => $request->input('is_active')
        ]);

        return redirect()->route('apiKeys.index')->with('message', 'API key updated successfully.');
    }
}
