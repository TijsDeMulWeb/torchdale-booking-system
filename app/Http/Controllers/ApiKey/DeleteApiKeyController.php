<?php

namespace App\Http\Controllers\ApiKey;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeleteApiKeyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $apiKey = auth()->user()->escaperoom->apiKeys()->where('id', $id)->firstOrFail();

        $apiKey->delete();

        return redirect()->route('apiKeys.index')->with('message', 'API key succesvol verwijderd.');
    }
}
