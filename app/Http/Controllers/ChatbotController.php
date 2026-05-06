<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use App\Models\Chatbot;

class ChatbotController extends Controller
{
    /**
     * Handle the incoming request.
     */

    public function __invoke(Request $request)
    {
        $escaperoom = $request->escaperoom;
        $messages = $request->chatHistory;

        $prompt = Chatbot::where('escaperoom_id', $escaperoom->id)->firstOrFail()->prompt;

        $result = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => array_merge(
                [['role' => 'system', 'content' => $prompt]],
                $messages,
            ),
        ]);

        $response = $result->choices[0]->message->content;


        return response()->json(['success' => true, 'message' => $response]);
    }
}
