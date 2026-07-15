<p align="center">
  <img src="public/logo/logo-figco-tran.png" width="120" alt="FigCo logo">
</p>

<h1 align="center">FigCo Teacher Assistant</h1>

<p align="center">
  An AI teaching sidekick for Cambodian classrooms — chat with an AI assistant, generate homework from lesson PDFs,<br/>
  and export polished worksheets in English or Khmer, all wrapped in a hand-sketched pixel-art UI.
</p>

---

## What is this?

FigCo Teacher Assistant is a Laravel app built for teachers who want an AI co-pilot without the AI-generated-slop aesthetic. It pairs a Laravel + Blade + Alpine.js frontend with [n8n](https://n8n.io) workflows running Google Gemini, so all the actual AI orchestration (prompting, image/video analysis, PDF parsing) lives in versioned, visually-editable n8n workflows rather than buried in application code.

Two core experiences:

- **Chat with Monika** — a warm, personality-driven AI teaching assistant (with an optional "Sussy Mode" for off-topic banter). Supports text, image analysis, and YouTube video summarization, and replies naturally in Khmer when a teacher writes in Khmer.
- **Homework Generator** — upload a lesson PDF, describe what you need ("10 multiple-choice questions with answer key," "fill-in-the-blank worksheet," etc.), and get back a fully generated homework document you can refine conversationally and export as PDF or DOCX — with full Khmer script and font support.

## Features

- 🗨️ **AI chat assistant** with conversation history, image understanding, and YouTube video summarization (Gemini's native video-URL input)
- 📄 **PDF → Homework generation** via an async n8n workflow + Laravel webhook callback, with live status polling on the frontend
- 🇰🇭 **First-class Khmer support** — UI locale switching, Khmer-aware AI prompting, and Khmer PDF export via mPDF with a bundled Noto Khmer font (with automatic fallback for unsupported glyph sets)
- ✍️ **Conversational refinement** — ask the AI to tweak generated homework in place ("make question 3 harder," "add a rubric") without starting over
- 📤 **Export to PDF or DOCX** (DomPDF for Latin scripts, mPDF for Khmer, PhpWord for Word docs)
- 🎨 **Distinctive hand-sketched pixel-art design system** — thick borders, hard drop-shadows, and a warm off-white palette instead of generic AI-app gradients
- 🔐 Per-user API key management, email verification, and standard Laravel auth (via Breeze)

## Tech Stack

| Layer | Choice |
|---|---|
| Backend | Laravel 13, PHP 8.4+ |
| Frontend | Blade, Alpine.js, Tailwind CSS, Vite |
| Database | PostgreSQL (hosted on Supabase) |
| AI orchestration | [n8n](https://n8n.io) workflows (webhook-triggered) |
| AI model | Google Gemini (chat, image analysis, video analysis) |
| PDF export | DomPDF (Latin) / mPDF (Khmer) |
| DOCX export | PhpOffice/PhpWord |
| Deployment | Docker → Railway |

## How it fits together

```
Browser ──▶ Laravel (Blade + Alpine) ──▶ n8n webhook ──▶ Gemini AI
                     ▲                         │
                     └────── callback ─────────┘
                     (homework_id + generated HTML)
```

Laravel never talks to Gemini directly — it hands off work to n8n via webhook and either waits synchronously (chat) or receives an async callback once the workflow finishes (homework generation, since PDF processing can take longer than a typical request timeout). All prompt engineering, model selection, and multi-step logic (e.g. "does this message contain an image or a YouTube link?") lives in the n8n workflows themselves, making them independently testable and editable without a deploy.

## Getting Started

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate

# configure DB + n8n webhook URLs in .env, then:
php artisan migrate

npm run dev        # in one terminal
php artisan serve  # in another
```

Required `.env` values beyond the Laravel defaults:

```env
DB_CONNECTION=pgsql
DB_HOST=...
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...

N8N_CHAT_WEBHOOK_URL=...
N8N_HOMEWORK_WEBHOOK_URL=...
N8N_CALLBACK_SECRET=...
```

> **Note:** `upload_max_filesize`, `post_max_size`, `memory_limit`, and `max_execution_time` in your local `php.ini` need to comfortably exceed the 20MB PDF upload limit — base64-encoding a multi-MB PDF for the n8n handoff is memory- and time-intensive. See [docker/php/uploads.ini](docker/php/uploads.ini) for the values used in production.

## Deployment

Ships as a Docker image (see [Dockerfile](Dockerfile)) targeting [Railway](https://railway.app). The image bundles the Noto Khmer font for PDF generation and patches a known mPDF glyph-set crash on first build.

## License

Built on the [MIT-licensed](https://opensource.org/licenses/MIT) Laravel framework.
