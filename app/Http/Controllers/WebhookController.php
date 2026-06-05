<?php

namespace App\Http\Controllers;

use App\Models\HomeworkRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebhookController extends Controller
{
    public function homeworkCallback(Request $request)
    {
        if ($request->input('callback_secret') !== config('services.n8n.callback_secret')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $hw = HomeworkRequest::findOrFail($request->input('homework_id'));

        if ($request->input('status') === 'failed') {
            $hw->update([
                'status'        => 'failed',
                'error_message' => $request->input('error_message', 'Generation failed.'),
            ]);
            return response()->json(['ok' => true]);
        }

        $content = $request->input('homework_content', '');

        // Mark completed immediately so the frontend stops polling
        $hw->update([
            'status'           => 'completed',
            'homework_content' => $content,
        ]);

        // Generate files — failures don't block the completed status
        try {
            $pdfPath = $this->generatePdf($hw, $content);
            $hw->update(['result_pdf_path' => $pdfPath]);
        } catch (\Throwable $e) {
            \Log::error("Homework PDF generation failed for #{$hw->id}: " . $e->getMessage());
        }

        try {
            $docxPath = $this->generateDocx($hw, $content);
            $hw->update(['result_docx_path' => $docxPath]);
        } catch (\Throwable $e) {
            \Log::error("Homework DOCX generation failed for #{$hw->id}: " . $e->getMessage());
        }

        return response()->json(['ok' => true]);
    }

    private function generatePdf(HomeworkRequest $hw, string $content): string
    {
        $html = $this->wrapHtml($hw->original_filename, $content);
        $pdf  = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html);
        $path = 'homework-results/' . $hw->id . '.pdf';
        Storage::disk('local')->put($path, $pdf->output());
        return $path;
    }

    private function generateDocx(HomeworkRequest $hw, string $content): string
    {
        $phpWord  = new \PhpOffice\PhpWord\PhpWord();
        $section  = $phpWord->addSection();
        $section->addTitle(pathinfo($hw->original_filename, PATHINFO_FILENAME), 1);
        $section->addTextBreak(1);

        foreach (explode("\n", strip_tags($content)) as $line) {
            $line = trim($line);
            if ($line === '') {
                $section->addTextBreak(1);
            } else {
                $section->addText(htmlspecialchars_decode($line));
            }
        }

        $path    = 'homework-results/' . $hw->id . '.docx';
        $tmpPath = tempnam(sys_get_temp_dir(), 'hw_') . '.docx';
        $writer  = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tmpPath);
        Storage::disk('local')->put($path, file_get_contents($tmpPath));
        unlink($tmpPath);
        return $path;
    }

    private function wrapHtml(string $title, string $content): string
    {
        $safeTitle = htmlspecialchars(pathinfo($title, PATHINFO_FILENAME));
        return <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <style>
                body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; line-height: 1.6; margin: 40px; }
                h1, h2, h3 { color: #1e293b; }
                h1 { font-size: 20px; border-bottom: 2px solid #0058be; padding-bottom: 8px; }
                p  { margin: 8px 0; }
            </style>
        </head>
        <body>
            <h1>{$safeTitle}</h1>
            {$content}
        </body>
        </html>
        HTML;
    }
}
