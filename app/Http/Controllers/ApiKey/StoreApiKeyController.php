<?php

namespace App\Http\Controllers\ApiKey;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApiKeyRequest;
use App\Services\ApiKeyService;
use App\Models\ApiKey;

class StoreApiKeyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreApiKeyRequest $request)
    {
        $apiKeyService = new ApiKeyService();
        $keys = $apiKeyService->generateApiKeys();

        ApiKey::create([
            'escaperoom_id' => auth()->user()->escaperoom_id,
            'name' => $request->name,
            'public_key' => $keys['public_key'],
            'secret_hash' => $keys['secret_hash_store'],
            'allowed_origin' => $request->allowed_origin,
        ]);

        return redirect()->route('apiKeys.index')->with([
            'new_public_key' => $keys['public_key'],
            'new_secret_key' => $keys['secret_key'],
        ]);
    }
}
