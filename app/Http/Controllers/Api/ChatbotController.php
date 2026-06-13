<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ChatbotAgent\ChatbotService;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    protected ChatbotService $chatbot;

    public function __construct(ChatbotService $chatbot)
    {
        $this->chatbot = $chatbot;
    }

    /**
     * Xử lý tin nhắn chat từ widget
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array',
        ]);

        $message = $request->input('message');
        $history = $request->input('history', []);

        $response = $this->chatbot->chat($message, $history);

        return response()->json([
            'success' => true,
            'data' => $response,
        ]);
    }
}
