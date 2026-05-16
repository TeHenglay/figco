<?php

namespace App\Services;

use App\Models\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class N8nWebhookService
{
    public function trigger(Component $component, string $figmaToken): bool
    {
        $parser = new FigmaUrlParser();
        $parsed = $parser->parse($component->figma_url);

        $payload = [
            'component_id'  => $component->id,
            'file_key'      => $parsed['file_key'],
            'node_id'       => $parsed['node_id'],
            'framework'     => $component->framework,
            'figma_token'   => $figmaToken,
            'callback_url'  => route('webhook.n8n'),
            'callback_secret' => config('services.n8n.callback_secret'),
        ];

        try {
            $response = Http::timeout(10)->post(config('services.n8n.webhook_url'), $payload);
            return $response->successful();
        } catch (\Exception $e) {
            Log::error('n8n webhook failed', ['error' => $e->getMessage(), 'component_id' => $component->id]);
            return false;
        }
    }
}
