<?php

namespace App\Http\Controllers;

use App\Models\Component;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function n8n(Request $request)
    {
        if ($request->input('callback_secret') !== config('services.n8n.callback_secret')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $component = Component::findOrFail($request->input('component_id'));
        $status = $request->input('status', 'done');
        $startedAt = now()->subMilliseconds($request->input('duration_ms', 0));

        $component->update([
            'status'         => $status,
            'generated_code' => $request->input('code'),
            'thumbnail_url'  => $request->input('thumbnail_url'),
        ]);

        $component->logs()->create([
            'n8n_execution_id' => $request->input('execution_id'),
            'status'           => $status,
            'error_message'    => $request->input('error_message'),
            'duration_ms'      => $request->input('duration_ms'),
        ]);

        return response()->json(['ok' => true]);
    }
}
