<?php

namespace App\Http\Controllers;

use App\Models\HomeworkRequest;
use App\Services\N8nService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeworkController extends Controller
{
    public function index()
    {
        $requests = auth()->user()->homeworkRequests()->latest()->paginate(12);
        return view('homework.index', compact('requests'));
    }

    public function create()
    {
        return view('homework.create');
    }

    public function store(Request $request, N8nService $n8n)
    {
        $validated = $request->validate([
            'pdf'          => 'required|file|mimes:pdf|max:20480',
            'instructions' => 'required|string|max:3000',
        ]);

        $file = $request->file('pdf');
        $path = $file->store('homework-uploads', 'local');

        $hw = auth()->user()->homeworkRequests()->create([
            'original_filename' => $file->getClientOriginalName(),
            'file_path'         => $path,
            'instructions'      => $validated['instructions'],
            'status'            => 'processing',
        ]);

        $pdfBase64 = base64_encode(Storage::disk('local')->get($path));

        $n8n->triggerHomework(
            $hw->id,
            $pdfBase64,
            $file->getClientOriginalName(),
            $validated['instructions'],
            route('webhook.n8n.homework')
        );

        return redirect()->route('homework.show', $hw)->with('info', 'Your homework is being generated...');
    }

    public function show(HomeworkRequest $homework)
    {
        abort_if($homework->user_id !== auth()->id(), 403);
        return view('homework.show', compact('homework'));
    }

    public function status(HomeworkRequest $homework)
    {
        abort_if($homework->user_id !== auth()->id(), 403);
        return response()->json(['status' => $homework->status]);
    }

    public function download(HomeworkRequest $homework, string $format)
    {
        abort_if($homework->user_id !== auth()->id(), 403);
        abort_if($homework->status !== 'completed', 404);
        abort_unless(in_array($format, ['pdf', 'docx']), 404);

        $path = $format === 'pdf' ? $homework->result_pdf_path : $homework->result_docx_path;
        abort_if(!$path || !Storage::disk('local')->exists($path), 404);

        $mime = $format === 'pdf' ? 'application/pdf'
            : 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';

        return Storage::disk('local')->download($path, $homework->original_filename . '.' . $format, [
            'Content-Type' => $mime,
        ]);
    }

    public function destroy(HomeworkRequest $homework)
    {
        abort_if($homework->user_id !== auth()->id(), 403);
        Storage::disk('local')->delete($homework->file_path);
        if ($homework->result_pdf_path) Storage::disk('local')->delete($homework->result_pdf_path);
        if ($homework->result_docx_path) Storage::disk('local')->delete($homework->result_docx_path);
        $homework->delete();
        return redirect()->route('homework.index')->with('success', 'Homework deleted.');
    }
}
