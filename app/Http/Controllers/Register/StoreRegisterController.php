<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterRequest;
use App\Models\Escaperoom;
use App\Models\EscaperoomSetting;
use App\Models\ApiKey;
use App\Services\ApiKeyService;

class StoreRegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreRegisterRequest $request)
    {
        $escaperoom = Escaperoom::create($request->validated());

        $apiKeyService = new ApiKeyService();
        $keys = $apiKeyService->generateApiKeys();

        EscaperoomSetting::create([
            'escaperoom_id' => $escaperoom->id,
        ]);

        ApiKey::create([
            'escaperoom_id' => $escaperoom->id,
            'name' => 'Default API Key',
            'public_key' => $keys['public_key'],
            'secret_hash' => $keys['secret_hash_store'],
            'allowed_origin' => null,
        ]);

        return redirect()->route('register')->with('message', 'Je escaperoom is succesvol geregistreerd! Je escaperoom zal nu gevalideerd worden door de beheerder. Je ontvangt een e-mail zodra je escaperoom gevalideerd is.');
    }
}
