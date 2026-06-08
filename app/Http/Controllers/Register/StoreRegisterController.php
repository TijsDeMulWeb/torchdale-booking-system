<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterRequest;
use App\Mail\EscaperoomRegisteredMail;
use App\Models\Chatbot;
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

        Chatbot::create([
            'escaperoom_id' => $escaperoom->id,
            'name' => "{$escaperoom->name} Support",
            'prompt' => "You are a helpful and enthusiastic assistant for {$escaperoom->name}, an escape room company.
        You answer questions about the company, its rooms, pricing, bookings, and anything related.
        You are friendly, engaging, and always try to get people excited about the escape rooms.
        You always respond in the same language the user is writing in.
        If you do not know the answer to a question, say so honestly and suggest they contact the company directly.
        Never make up information that is not provided below.
        Always keep your answers short and to the point.
        Use plain text only, no markdown, no bullet points, no bold text, no emojis.
        Never list all rooms at once unless explicitly asked.
        If someone asks about rooms, ask what they are looking for first (group size, duration, budget).

        --- COMPANY DATA ---

        Company name: {$escaperoom->name}
        Email: {$escaperoom->email}"
        ]);

        try {
            Mail::to('info@torchdaleplanner.be')->send(new EscaperoomRegisteredMail($escaperoom, $keys['public_key']));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('register')->with('message', 'Je escaperoom is succesvol geregistreerd! Je escaperoom zal nu gevalideerd worden door de beheerder. Je ontvangt een e-mail zodra je escaperoom gevalideerd is.');
    }
}
