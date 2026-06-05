<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class N8nService
{
    public function callChatSync(int $conversationId, int $userId, string $message, array $history): string
    {
        $response = Http::timeout(60)->post(config('services.n8n.chat_webhook_url'), [
            'conversation_id' => $conversationId,
            'user_id'         => $userId,
            'message'         => $message,
            'history'         => $history,
        ]);

        if ($response->failed()) {
            Log::error('n8n chat webhook failed', ['status' => $response->status(), 'body' => $response->body()]);
            return 'Sorry, I am having trouble connecting right now. Please try again.';
        }

        return $response->json('reply') ?? $response->body();
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
