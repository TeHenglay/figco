<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Services\N8nService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function index()
    {
        $conversations = auth()->user()->conversations()->latest()->get();
        return view('chat.index', compact('conversations'));
    }

    public function store()
    {
        $conversation = auth()->user()->conversations()->create(['title' => 'New Conversation']);
        return redirect()->route('chat.show', $conversation);
    }

    public function show(Conversation $conversation)
    {
        abort_if($conversation->user_id !== auth()->id(), 403);
        $messages = $conversation->messages()->orderBy('created_at')->get();
        return view('chat.show', compact('conversation', 'messages'));
    }

    public function sendMessage(Request $request, Conversation $conversation, N8nService $n8n)
    {
        abort_if($conversation->user_id !== auth()->id(), 403);

        $validated = $request->validate(['message' => 'required|string|max:5000']);

        $conversation->messages()->create(['role' => 'user', 'content' => $validated['message']]);

        if ($conversation->messages()->count() === 1) {
            $conversation->update(['title' => Str::limit($validated['message'], 60)]);
        }

        // Build cross-session history for Gemini context
        $history = Message::whereHas('conversation', fn ($q) => $q->where('user_id', auth()->id()))
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->sortBy('created_at')
            ->map(fn ($m) => ['role' => $m->role, 'content' => $m->content])
            ->values()
            ->toArray();

        try {
            $reply = $n8n->callChatSync($conversation->id, auth()->id(), $validated['message'], $history);
        } catch (\Throwable $e) {
            \Log::error('Chat sendMessage error', ['error' => $e->getMessage()]);
            $reply = 'Sorry, I had trouble responding. Please try again.';
        }

        try {
            $assistantMessage = $conversation->messages()->create(['role' => 'assistant', 'content' => $reply]);
            $conversation->touch();
        } catch (\Throwable $e) {
            \Log::error('Chat DB save error', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => [
                    'role'       => 'assistant',
                    'content'    => $reply,
                    'created_at' => now()->toISOString(),
                ],
            ]);
        }

        return response()->json([
            'message' => [
                'role'       => $assistantMessage->role,
                'content'    => $assistantMessage->content,
                'created_at' => $assistantMessage->created_at->toISOString(),
            ],
        ]);
    }

    public function destroy(Conversation $conversation)
    {
        abort_if($conversation->user_id !== auth()->id(), 403);
        $conversation->delete();
        return redirect()->route('chat.index')->with('success', 'Conversation deleted.');
    }
}
