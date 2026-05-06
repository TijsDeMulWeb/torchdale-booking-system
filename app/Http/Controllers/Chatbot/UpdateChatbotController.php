<?php

namespace App\Http\Controllers\Chatbot;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChatbotRequest;
use App\Models\Chatbot;

class UpdateChatbotController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreChatbotRequest $request)
    {
        Chatbot::where('escaperoom_id', auth()->user()->escaperoom_id)->firstOrFail()->update($request->validated());

        return redirect()->route('chatbot.show')->with('message', 'Chatbot succesvol bijgewerkt.');
    }
}
