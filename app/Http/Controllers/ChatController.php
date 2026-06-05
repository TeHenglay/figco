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

        $validated = $request->validate([
            'message' => 'nullable|string|max:5000',
            'image'   => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,bmp,pdf|max:10240',
        ]);

        if (empty($validated['message']) && !$request->hasFile('image')) {
            return response()->json(['error' => 'Message or image required.'], 422);
        }

        $messageText = $validated['message'] ?? '';

        $imageBase64   = null;
        $imageMimeType = null;
        if ($request->hasFile('image')) {
            $file          = $request->file('image');
            $imageBase64   = base64_encode(file_get_contents($file->getRealPath()));
            $imageMimeType = $file->getMimeType();
        }

        $userContent = $messageText ?: '📎 [Image]';
        $conversation->messages()->create(['role' => 'user', 'content' => $userContent]);

        if ($conversation->messages()->count() === 1) {
            $conversation->update(['title' => Str::limit($userContent, 60)]);
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
            $reply = $n8n->callChatSync($conversation->id, auth()->id(), $messageText, $history, $imageBase64, $imageMimeType);
        } catch (\Throwable $e) {
            \Log::error('Chat sendMessage error', ['error' => $e->getMessage()]);
            $reply = 'Sorry, I had trouble responding. Please try again.';
        }

        try {
            $assistantMessage = $conversation->messages()->create(['role' => 'assistant', 'content' => $reply, 'created_at' => now()]);
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
                'created_at' => $assistantMessage->created_at?->toISOString() ?? now()->toISOString(),
            ],
        ]);
    }

    public function downloadMessage(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'format'  => 'required|in:pdf,docx',
            'title'   => 'nullable|string|max:100',
        ]);

        $title   = $validated['title'] ?? 'Monika - Response';
        $format  = $validated['format'];
        $html    = \Illuminate\Support\Str::markdown($validated['content']);

        return $format === 'pdf'
            ? $this->callStreamPdf($title, $html)
            : $this->callStreamDocx($title, $html);
    }

    private function callStreamPdf(string $title, string $content): \Symfony\Component\HttpFoundation\Response
    {
        $safeTitle = htmlspecialchars($title);
        $html = <<<HTML
        <!DOCTYPE html><html><head><meta charset="utf-8">
        <style>
            body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; line-height: 1.6; margin: 40px; }
            h1,h2,h3 { color: #1e293b; } h1 { font-size: 20px; border-bottom: 2px solid #0058be; padding-bottom: 8px; margin-bottom: 16px; }
            p { margin: 8px 0; } ul,ol { margin: 8px 0; padding-left: 20px; } li { margin: 4px 0; }
            strong { font-weight: bold; } em { font-style: italic; }
            code { background: #f1f5f9; padding: 1px 4px; font-family: monospace; }
        </style></head><body><h1>{$safeTitle}</h1>{$content}</body></html>
        HTML;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
        return response($pdf->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $title . '.pdf"',
        ]);
    }

    private function callStreamDocx(string $title, string $content): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $section->addTitle($title, 1);
        $section->addTextBreak(1);

        foreach (explode("\n", strip_tags($content)) as $line) {
            $line = trim($line);
            $line === '' ? $section->addTextBreak(1) : $section->addText(htmlspecialchars_decode($line));
        }

        $tmpPath = tempnam(sys_get_temp_dir(), 'chat_') . '.docx';
        \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007')->save($tmpPath);

        return response()->streamDownload(function () use ($tmpPath) {
            readfile($tmpPath);
            @unlink($tmpPath);
        }, $title . '.docx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);
    }

    public function destroy(Conversation $conversation)
    {
        abort_if($conversation->user_id !== auth()->id(), 403);
        $conversation->delete();
        return redirect()->route('chat.index')->with('success', 'Conversation deleted.');
    }
}
