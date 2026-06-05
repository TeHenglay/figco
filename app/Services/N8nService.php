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

        Log::info('n8n chat raw response', ['status' => $response->status(), 'body' => $response->body()]);

        $data = $response->json();

        // n8n may return an array [{...}] or a plain object {...}
        $item = is_array($data) && isset($data[0]) ? $data[0] : $data;

        $reply = $item['reply'] ?? $item['text'] ?? $item['response'] ?? $item['output'] ?? $item['message'] ?? null;

        if (is_string($reply) && trim($reply) !== '') {
            return trim($reply);
        }

        // Last resort: if the whole body is a plain non-JSON string
        $body = trim($response->body());
        if ($body !== '' && !str_starts_with($body, '{') && !str_starts_with($body, '[')) {
            return $body;
        }

        Log::warning('n8n chat: could not extract reply', ['data' => $data]);
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
