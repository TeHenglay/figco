# Design-to-Code Studio — Build Progress

> Last updated: 2026-05-02

---

## ✅ Completed

- [x] Create new Laravel project (`design-to-code-studio`)
- [x] Install Laravel Breeze (auth scaffolding with dark mode)
- [x] Create migrations — `projects`, `components`, `generation_logs`, `figma_token` on users
- [x] Create models with relationships — `Project`, `Component`, `GenerationLog`, `User`
- [x] Create controllers — `ProjectController`, `ComponentController`, `WebhookController`
- [x] Create services — `FigmaUrlParser`, `N8nWebhookService`
- [x] Create `ProjectPolicy` (authorization — users can only access their own projects)
- [x] Set up routes (`web.php` + webhook route `/webhook/n8n`)
- [x] Add n8n + Figma config to `config/services.php`

---

## ⏳ Blocked — Waiting on Credentials

- [ ] Fill in `.env` Supabase (PostgreSQL) credentials
  - `DB_HOST`, `DB_USERNAME`, `DB_PASSWORD`
  - Get from: Supabase Dashboard → Settings → Database → Connection Pooling
- [ ] Fill in `.env` n8n webhook URL
  - `N8N_WEBHOOK_URL=https://your-n8n/webhook/design-to-code`
  - Create workflow in n8n first, then paste the webhook URL
- [ ] Fill in `.env` Figma access token
  - `FIGMA_ACCESS_TOKEN=figd_xxxxx`
  - Get from: Figma → Settings → Personal access tokens

---

## 📋 Up Next (after credentials)

- [ ] Run `php artisan migrate` on Supabase
- [x] Build Blade views — projects index, create, show
- [x] Build Blade views — component create, show (side-by-side preview)
- [x] Build dashboard layout (navigation, dark mode) — uses Breeze x-app-layout
- [x] Add Figma token field to profile settings page
- [x] Add live status polling with Alpine.js on component detail page (polls every 3 s, reloads on done)
- [x] Add syntax highlighting with Prism.js to generated code view
- [ ] Test full flow end-to-end (Figma URL → n8n → AI → Laravel → preview)

---

## 📁 Project Structure So Far

```
app/
├── Http/Controllers/
│   ├── ComponentController.php
│   ├── ProjectController.php
│   └── WebhookController.php
├── Models/
│   ├── Component.php
│   ├── GenerationLog.php
│   ├── Project.php
│   └── User.php
├── Policies/
│   └── ProjectPolicy.php
└── Services/
    ├── FigmaUrlParser.php
    └── N8nWebhookService.php

database/migrations/
├── ..._add_figma_token_to_users_table.php
├── ..._create_projects_table.php
├── ..._create_components_table.php
└── ..._create_generation_logs_table.php

routes/
└── web.php   ← includes /webhook/n8n
```

---

## 🔑 .env Keys to Fill In

```env
DB_CONNECTION=pgsql
DB_HOST=aws-0-ap-southeast-1.pooler.supabase.com
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=your-supabase-username
DB_PASSWORD=your-supabase-password

N8N_WEBHOOK_URL=https://your-n8n-instance/webhook/design-to-code
N8N_CALLBACK_SECRET=pick-any-secret-string

FIGMA_ACCESS_TOKEN=figd_xxxxxxxxxxxxx
```
