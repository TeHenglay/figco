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
            'language'     => 'nullable|in:English,Khmer',
        ]);

        $file = $request->file('pdf');
        $path = $file->store('homework-uploads', 'local');

        $language = $validated['language'] ?? 'English';

        $languageInstruction = $language === 'Khmer'
            ? "\n\nIMPORTANT: Generate ALL output in Khmer (ភាសាខ្មែរ) only. Every title, question, instruction, and answer key must be written in Khmer script. Do not use English."
            : "\n\nIMPORTANT: Generate ALL output in English only.";

        $instructions = $validated['instructions'] . $languageInstruction;

        $hw = auth()->user()->homeworkRequests()->create([
            'original_filename' => $file->getClientOriginalName(),
            'file_path'         => $path,
            'instructions'      => $validated['instructions'],
            'status'            => 'processing',
        ]);

        $pdfBase64 = base64_encode(Storage::disk('local')->get($path));

        $callbackUrl = rtrim(config('app.url'), '/') . '/webhook/n8n/homework';

        $n8n->triggerHomework(
            $hw->id,
            $pdfBase64,
            $file->getClientOriginalName(),
            $instructions,
            $callbackUrl,
            $language
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

    public function timeout(HomeworkRequest $homework)
    {
        abort_if($homework->user_id !== auth()->id(), 403);
        if (in_array($homework->status, ['processing', 'pending'])) {
            $homework->update([
                'status'        => 'failed',
                'error_message' => 'Generation timed out after 3 minutes. The AI took too long to respond. Please try again.',
            ]);
        }
        return response()->json(['ok' => true]);
    }

    public function refine(Request $request, HomeworkRequest $homework, N8nService $n8n)
    {
        abort_if($homework->user_id !== auth()->id(), 403);
        abort_if($homework->status !== 'completed', 422);

        $validated = $request->validate([
            'instruction' => 'required|string|max:1000',
        ]);

        $updated = $n8n->refineHomework($homework->homework_content ?? '', $validated['instruction']);

        if ($updated === '') {
            return response()->json(['error' => 'AI refinement failed. Please try again.'], 500);
        }

        $homework->update(['homework_content' => $updated]);

        return response()->json(['content' => $updated]);
    }

    public function download(HomeworkRequest $homework, string $format)
    {
        abort_if($homework->user_id !== auth()->id(), 403);
        abort_if($homework->status !== 'completed', 404);
        abort_unless(in_array($format, ['pdf', 'docx']), 404);

        $content  = $homework->homework_content ?? '';
        $basename = pathinfo($homework->original_filename, PATHINFO_FILENAME);

        if ($format === 'pdf') {
            return $this->streamPdf($basename, $content);
        }

        return $this->streamDocx($basename, $content);
    }

    private function streamPdf(string $title, string $content): \Symfony\Component\HttpFoundation\Response
    {
        $safeTitle = htmlspecialchars($title);

        $hasKhmer = (bool) preg_match('/[\x{1780}-\x{17FF}]/u', $content . $title);

        $khmerFontPath = storage_path('fonts/NotoKhmer.ttf');
        $khmerFontFace = '';
        $fontFamily    = "'DejaVu Sans', sans-serif";

        if ($hasKhmer && file_exists($khmerFontPath)) {
            // Register font for ALL weights so bold/strong elements don't fall back
            $khmerFontFace = '
                @font-face { font-family: "NotoKhmer"; src: url("' . $khmerFontPath . '") format("truetype"); font-weight: normal; font-style: normal; }
                @font-face { font-family: "NotoKhmer"; src: url("' . $khmerFontPath . '") format("truetype"); font-weight: bold; font-style: normal; }
                @font-face { font-family: "NotoKhmer"; src: url("' . $khmerFontPath . '") format("truetype"); font-weight: 100 900; font-style: normal; }
            ';
            $fontFamily = '"NotoKhmer", "DejaVu Sans", sans-serif';
        }

        $html = <<<HTML
        <!DOCTYPE html><html><head><meta charset="utf-8">
        <style>
            {$khmerFontFace}
            * { font-family: {$fontFamily}; }
            body { font-size: 12px; color: #111; line-height: 2.2; margin: 40px; }
            h1,h2,h3 { color: #1e293b; font-family: {$fontFamily}; }
            h1 { font-size: 20px; border-bottom: 2px solid #0058be; padding-bottom: 8px; margin-bottom: 16px; }
            h2 { font-size: 16px; margin-top: 20px; }
            h3 { font-size: 14px; }
            strong, b { font-family: {$fontFamily}; }
            p { margin: 8px 0; }
            ol, ul { padding-left: 20px; } li { margin: 4px 0; }
        </style></head><body><h1>{$safeTitle}</h1>{$content}</body></html>
        HTML;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);

        return response($pdf->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $title . '.pdf"',
        ]);
    }

    private function streamDocx(string $title, string $content): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $section->addTitle($title, 1);
        $section->addTextBreak(1);

        foreach (explode("\n", strip_tags($content)) as $line) {
            $line = trim($line);
            $line === '' ? $section->addTextBreak(1) : $section->addText(htmlspecialchars_decode($line));
        }

        $tmpPath = tempnam(sys_get_temp_dir(), 'hw_') . '.docx';
        \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007')->save($tmpPath);

        return response()->streamDownload(function () use ($tmpPath) {
            readfile($tmpPath);
            @unlink($tmpPath);
        }, $title . '.docx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
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
