<?php

namespace App\Http\Controllers\Chatbot;

use App\Http\Controllers\Controller;
use App\Models\Chatbot;
use App\Models\EscaperoomSetting;
use Illuminate\Http\Request;

class ShowChatbotController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        abort_if(!auth()->user()->can('view chatbot'), 403);

        return view('chatbot.show', [
            'chatbot' => Chatbot::where('escaperoom_id', auth()->user()->escaperoom_id)->firstOrFail(),
            'setting' => EscaperoomSetting::where('escaperoom_id', auth()->user()->escaperoom_id)->firstOrFail(),
        ]);
    }
}
