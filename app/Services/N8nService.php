<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class N8nService
{
    public function callChatSync(int $conversationId, int $userId, string $message, array $history): string
    {
        try {
            $response = Http::timeout(60)->post(config('services.n8n.chat_webhook_url'), [
                'conversation_id' => $conversationId,
                'user_id'         => $userId,
                'message'         => $message,
                'history'         => $history,
            ]);
        } catch (\Throwable $e) {
            Log::error('n8n chat connection error', ['error' => $e->getMessage()]);
            return 'Sorry, I had trouble responding. Please try again.';
        }

        if ($response->failed()) {
            Log::error('n8n chat webhook failed', ['status' => $response->status(), 'body' => $response->body()]);
            return 'Sorry, I had trouble responding. Please try again.';
        }

        // Try common reply keys before giving up
        $data  = $response->json() ?? [];
        $reply = $data['reply'] ?? $data['text'] ?? $data['response'] ?? $data['output'] ?? null;

        if (is_string($reply) && trim($reply) !== '') {
            return trim($reply);
        }

        Log::warning('n8n chat: unexpected response format', ['body' => $response->body()]);
        return 'Sorry, I had trouble responding. Please try again.';
    }

    public function triggerHomework(int $homeworkId, string $pdfBase64, string $filename, string $instructions, string $callbackUrl): void
    {
        Http::timeout(15)->post(config('services.n8n.homework_webhook_url'), [
            'homework_id'     => $homeworkId,
            'pdf_base64'      => $pdfBase64,
            'filename'        => $filename,
            'instructions'    => $instructions,
            'callback_url'    => $callbackUrl,
            'callback_secret' => config('services.n8n.callback_secret'),
        ]);
    }
}
