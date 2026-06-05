<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class N8nService
{
    public function callChatSync(int $conversationId, int $userId, string $message, array $history, ?string $imageBase64 = null, ?string $imageMimeType = null): string
    {
        $systemInstruction = 'You are Monika, a friendly AI teaching assistant. Keep your replies concise and to the point — avoid long paragraphs. Use short sentences. Only give detailed or structured output (like lesson plans or quizzes) when the user explicitly asks for a document or full plan.';

        $payload = [
            'conversation_id'    => $conversationId,
            'user_id'            => $userId,
            'message'            => $message,
            'history'            => $history,
            'system_instruction' => $systemInstruction,
        ];

        if ($imageBase64 !== null) {
            $payload['image_base64']   = $imageBase64;
            $payload['image_mime_type'] = $imageMimeType ?? 'image/jpeg';
        }

        try {
            $response = Http::timeout(90)->withoutVerifying()->post(config('services.n8n.chat_webhook_url'), $payload);
        } catch (\Throwable $e) {
            Log::error('n8n chat connection error', ['error' => $e->getMessage()]);
            return 'Sorry, I had trouble responding. Please try again.';
        }

        if ($response->failed()) {
            Log::error('n8n chat webhook failed', ['status' => $response->status(), 'body' => $response->body()]);
            return 'Sorry, I had trouble responding. Please try again.';
        }

        Log::info('n8n chat raw response', ['status' => $response->status(), 'body' => substr($response->body(), 0, 500)]);

        $data = $response->json();

        // n8n may return [{...}] or {...}
        $item = is_array($data) && isset($data[0]) ? $data[0] : $data;

        $raw = $item['reply'] ?? $item['text'] ?? $item['content'] ?? $item['response'] ?? $item['output'] ?? $item['message'] ?? null;

        $reply = $this->extractText($raw);

        if ($reply !== null) {
            return $reply;
        }

        // Last resort: plain text body
        $body = trim($response->body());
        if ($body !== '' && !str_starts_with($body, '{') && !str_starts_with($body, '[')) {
            return $body;
        }

        Log::warning('n8n chat: could not extract reply', ['data' => $data]);
        return 'Sorry, I had trouble responding. Please try again.';
    }

    private function extractText(mixed $value): ?string
    {
        if (is_string($value) && trim($value) !== '') {
            return trim($value);
        }

        if (is_array($value)) {
            // Gemini content object: {parts: [{text: "..."}]}
            if (isset($value['parts'][0]['text'])) {
                return trim($value['parts'][0]['text']);
            }
            // Direct text field
            if (isset($value['text']) && is_string($value['text'])) {
                return trim($value['text']);
            }
            // candidates[0].content.parts[0].text
            if (isset($value['candidates'][0]['content']['parts'][0]['text'])) {
                return trim($value['candidates'][0]['content']['parts'][0]['text']);
            }
        }

        return null;
    }

    public function triggerHomework(int $homeworkId, string $pdfBase64, string $filename, string $instructions, string $callbackUrl, string $language = 'English'): void
    {
        Http::timeout(15)->withoutVerifying()->post(config('services.n8n.homework_webhook_url'), [
            'homework_id'     => $homeworkId,
            'pdf_base64'      => $pdfBase64,
            'filename'        => $filename,
            'instructions'    => $instructions,
            'language'        => $language,
            'callback_url'    => $callbackUrl,
            'callback_secret' => config('services.n8n.callback_secret'),
        ]);
    }
}
