# Design-to-Code Automation Studio

> Upload Figma designs → n8n converts via AI → stores in component library → side-by-side preview

---

## Overview

A medium-level Laravel + n8n project where users paste a Figma frame URL, choose a framework (React or Vue), and the system automatically generates a production-ready component using AI. All generated components are stored in a searchable library with a beautiful side-by-side preview.

---

## Tech Stack

| Layer         | Tech                          |
|---------------|-------------------------------|
| Backend       | Laravel 11                    |
| Frontend      | Blade + Tailwind CSS + Alpine.js |
| Automation    | n8n (self-hosted)             |
| Database      | PostgreSQL                    |
| AI            | Claude or OpenAI (via n8n)    |
| Code Highlight| Prism.js                      |
| Figma Preview | Figma Embed API               |

---

## Database Schema

```sql
users
  - id
  - name
  - email
  - figma_access_token   -- personal Figma API token

projects
  - id
  - user_id
  - name
  - figma_file_key

components
  - id
  - project_id
  - name
  - figma_node_id
  - figma_url
  - thumbnail_url
  - framework            -- "react" | "vue"
  - generated_code       -- text (the AI output)
  - status               -- "pending" | "processing" | "done" | "failed"
  - created_at

generation_logs
  - id
  - component_id
  - n8n_execution_id
  - status
  - error_message
  - duration_ms
```

---

## Request Flow

```
User pastes Figma URL + picks React/Vue
          ↓
Laravel extracts file_key + node_id from URL
Creates component record (status: pending)
          ↓
Laravel fires webhook → n8n
{ file_key, node_id, framework, component_id, callback_url }
          ↓
n8n Workflow:
  1. Figma API → GET /files/{file_key}/nodes     (design JSON)
  2. Figma API → GET /images/{file_key}           (PNG render)
  3. Code node → extract colors, fonts, spacing, layout
  4. Claude/OpenAI → generate component code
  5. POST result → Laravel callback URL
          ↓
Laravel receives generated code
Updates component (status: done, stores code + thumbnail)
          ↓
User sees side-by-side preview
```

---

## Laravel Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── ComponentController.php     -- CRUD + trigger n8n
│   │   ├── WebhookController.php       -- receive n8n callback
│   │   └── ProjectController.php
│   └── Requests/
│       ├── StoreComponentRequest.php
│       └── StoreProjectRequest.php
├── Models/
│   ├── Component.php
│   ├── Project.php
│   └── GenerationLog.php
└── Services/
    ├── FigmaUrlParser.php              -- extract file_key + node_id
    └── N8nWebhookService.php           -- fire webhook to n8n

routes/
├── web.php                             -- UI routes
└── api.php                             -- POST /api/webhook/n8n-callback
```

---

## n8n Workflow Nodes

```
[Webhook Trigger]
      ↓
[HTTP Request] GET Figma nodes API
  → https://api.figma.com/v1/files/{file_key}/nodes?ids={node_id}
      ↓
[HTTP Request] GET Figma image render
  → https://api.figma.com/v1/images/{file_key}?ids={node_id}&format=png
      ↓
[Code Node] Parse design tokens
  Extract: colors, fonts, font sizes, spacing,
           border-radius, shadows, layout direction
      ↓
[AI / OpenAI Node] Generate component
  Prompt:
  "Generate a {framework} component using Tailwind CSS
   based on these design tokens: {tokens}.
   Return only the component code, no explanation."
      ↓
[HTTP Request] POST → Laravel callback
  { component_id, code, thumbnail_url, status: "done" }
      ↓
[Error Branch] POST failure back
  { component_id, status: "failed", error_message }
```

---

## UI Pages

| Page                  | Description                                                  |
|-----------------------|--------------------------------------------------------------|
| **Dashboard**         | Recent components grid with thumbnails + status badges       |
| **New Component**     | Figma URL input + framework picker (React / Vue)             |
| **Component Library** | Searchable and filterable component grid                     |
| **Component Detail**  | Side-by-side: Figma embed (left) + syntax-highlighted code (right) |
| **Generation Status** | Live polling progress bar while n8n processes                |
| **Project Settings**  | Manage Figma personal access token + file key                |

---

## Side-by-Side Preview Layout

```
┌──────────────────────┬───────────────────────┐
│   Figma Embed        │   Generated Code       │
│                      │                        │
│  [iframe of frame]   │  <SyntaxHighlight>     │
│                      │    export default...   │
│                      │  </SyntaxHighlight>    │
│                      │                        │
│                      │  [Copy]  [Download]    │
└──────────────────────┴───────────────────────┘
```

---

## Figma URL Parser

Figma URLs follow this pattern:

```
https://www.figma.com/file/{FILE_KEY}/Title?node-id={NODE_ID}

Examples:
  file_key = "abc123XYZ"
  node_id  = "1234:5678"  →  URL-encode to "1234-5678" for API calls
```

**FigmaUrlParser.php logic:**
```php
// Extract file_key from URL path segment
// Extract node-id from query string
// Replace ":" with "-" for API compatibility
// Validate both are present before triggering workflow
```

---

## API Endpoints

```
GET    /                              Dashboard
GET    /projects                      Project list
POST   /projects                      Create project
GET    /projects/{project}            Project detail
GET    /projects/{project}/components Component library
POST   /projects/{project}/components Submit new Figma URL
GET    /components/{component}        Side-by-side detail page

POST   /api/webhook/n8n-callback      n8n posts result here (no auth, uses component_id + secret)
```

---

## Build Order (Recommended)

| Step | Task                                                  |
|------|-------------------------------------------------------|
| 1    | Auth + Figma personal access token storage on profile |
| 2    | DB migrations + models + relationships                |
| 3    | FigmaUrlParser service + validation                   |
| 4    | N8nWebhookService — fire webhook from Laravel         |
| 5    | n8n workflow — Figma API → AI → callback              |
| 6    | WebhookController — receive result, update component  |
| 7    | Component Library UI — grid with status badges        |
| 8    | Side-by-side detail page — Figma embed + Prism.js     |
| 9    | Generation status page — live polling with Alpine.js  |
| 10   | Polish — loading states, error messages, copy button  |

---

## n8n Setup (Self-Hosted)

```bash
# Install via Docker
docker run -it --rm \
  --name n8n \
  -p 5678:5678 \
  -v ~/.n8n:/home/node/.n8n \
  n8nio/n8n

# Access at: http://localhost:5678
```

Laravel `.env` additions:
```
N8N_WEBHOOK_URL=http://localhost:5678/webhook/design-to-code
N8N_CALLBACK_SECRET=your-secret-here
FIGMA_ACCESS_TOKEN=your-figma-token
```

---

## Estimated Timeline

| Week | Focus                                      |
|------|--------------------------------------------|
| 1    | Laravel setup, auth, DB, Figma URL parser  |
| 2    | n8n workflow + Figma API + AI integration  |
| 3    | Component library UI + side-by-side view   |
| 4    | Polish, error handling, live status        |
| 5    | Testing + deploy                           |

---

## Future Features (Post-MVP)

- Figma webhook for auto-sync on design changes
- Visual diff showing what changed between versions
- Export component to GitHub PR automatically
- Component consistency score (design vs. rendered)
- Team collaboration + comments on components
- Support for more frameworks (Svelte, Angular)
