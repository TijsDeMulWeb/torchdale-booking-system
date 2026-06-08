<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterRequest;
use App\Mail\EscaperoomRegisteredMail;
use App\Models\Escaperoom;
use App\Models\EscaperoomSetting;
use App\Models\ApiKey;
use App\Services\ApiKeyService;
use Illuminate\Support\Facades\Mail;

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

        try {
            Mail::to('info@torchdaleplanner.be')->send(new EscaperoomRegisteredMail($escaperoom, $keys['public_key']));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('register')->with('message', 'Je escaperoom is succesvol geregistreerd! Je escaperoom zal nu gevalideerd worden door de beheerder. Je ontvangt een e-mail zodra je escaperoom gevalideerd is.');
    }
}
