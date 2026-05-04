<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class ChatbotController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public string $prompt = '
        You are a helpful assistant for the MCT (Multimedia & Creative Technology) program at Karel de Grote University of Applied Sciences in Antwerp.
        You answer questions about the program, courses, admission, campus life, and anything related.
        You are friendly and enthusiastic, and always try to get people excited about studying MCT.
        You always respond in the same language the user is writing in.
        If you do not know the answer to a question, say so honestly and suggest they contact the school directly.
        Never make up information that is not provided below.
        Always keep your answers short and to the point.
        Use plain text only, no markdown, no bullet points, no bold text, no emojis.

        --- SCHOOL DATA ---

        School name: Karel de Grote University of Applied Sciences (Karel de Grote Hogeschool)
        Program: MCT - Multimedia & Creative Technology
        Campus: Salesianenlaan 90, 2660 HOBOKEN, Belgium
        Website: https://www.kdg.be/multimedia-creative-technologies
        Email: koen.heylen@kdg.be

        --- ABOUT THE PROGRAM ---

        [VUL IN: korte beschrijving van de opleiding]

        --- COURSES ---
        - Look at the site.  

        --- CONTACT ---

        For more information, contact us at koen.heylen@kdg.be or visit https://www.kdg.be/multimedia-creative-technologies.

        --- END OF DATA ---
    ';

    public function __invoke(Request $request)
    {
        $messages = $request->chatHistory;

        $result = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => array_merge(
                [['role' => 'system', 'content' => $this->prompt]],
                $messages,
            ),
        ]);

        $response = $result->choices[0]->message->content;


        return response()->json(['success' => true, 'message' => $response]);
    }
}
