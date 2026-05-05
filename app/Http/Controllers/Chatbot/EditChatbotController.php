<?php

namespace App\Http\Controllers\Chatbot;

use App\Http\Controllers\Controller;
use App\Models\Chatbot;
use Illuminate\Http\Request;

class EditChatbotController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('chatbot.edit', [
            'chatbot' => Chatbot::where('escaperoom_id', auth()->user()->escaperoom_id)->firstOrFail(),
        ]);
    }
}
