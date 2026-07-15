<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FigCo') }}</title>
    <link rel="icon" type="image/png" href="/logo/logo-figco.png">

    <!-- FigCo Design System Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100..900;1,100..900&family=Inter:opsz,wght@14..32,100..900&family=Space+Grotesk:wght@300..700&family=Kantumruy+Pro:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- Tailwind CDN with FigCo Config -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "surface": "#f9f9ff",
                        "surface-dim": "#cfdaf2",
                        "surface-bright": "#f9f9ff",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#f0f3ff",
                        "surface-container": "#e7eeff",
                        "surface-container-high": "#dee8ff",
                        "surface-container-highest": "#d8e3fb",
                        "on-surface": "#111c2d",
                        "on-surface-variant": "#424754",
                        "inverse-surface": "#263143",
                        "inverse-on-surface": "#ecf1ff",
                        "outline": "#727785",
                        "outline-variant": "#c2c6d6",
                        "surface-tint": "#005ac2",
                        "primary": "#0058be",
                        "on-primary": "#ffffff",
                        "primary-container": "#2170e4",
                        "on-primary-container": "#fefcff",
                        "inverse-primary": "#adc6ff",
                        "secondary": "#50616b",
                        "on-secondary": "#ffffff",
                        "secondary-container": "#d3e5f1",
                        "on-secondary-container": "#566771",
                        "tertiary": "#545d62",
                        "on-tertiary": "#ffffff",
                        "tertiary-container": "#6d767b",
                        "on-tertiary-container": "#fbfdff",
                        "error": "#ba1a1a",
                        "on-error": "#ffffff",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a",
                        "primary-fixed": "#d8e2ff",
                        "primary-fixed-dim": "#adc6ff",
                        "on-primary-fixed": "#001a42",
                        "on-primary-fixed-variant": "#004395",
                        "secondary-fixed": "#d3e5f1",
                        "secondary-fixed-dim": "#b7c9d5",
                        "on-secondary-fixed": "#0c1e26",
                        "on-secondary-fixed-variant": "#384953",
                        "tertiary-fixed": "#dbe4ea",
                        "tertiary-fixed-dim": "#bfc8ce",
                        "on-tertiary-fixed": "#141d21",
                        "on-tertiary-fixed-variant": "#3f484d",
                        "background": "#f9f9ff",
                        "on-background": "#111c2d",
                        "surface-variant": "#d8e3fb",
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    spacing: {
                        "gutter": "20px",
                        "stack-sm": "8px",
                        "container-padding": "24px",
                        "pixel-unit": "4px",
                        "stack-md": "16px",
                        "stack-lg": "32px"
                    },
                    fontFamily: {
                        "headline-xl": ["Epilogue", "Kantumruy Pro", "sans-serif"],
                        "headline-lg": ["Epilogue", "Kantumruy Pro", "sans-serif"],
                        "headline-md": ["Epilogue", "Kantumruy Pro", "sans-serif"],
                        "body-lg": ["Inter", "Kantumruy Pro", "sans-serif"],
                        "body-md": ["Inter", "Kantumruy Pro", "sans-serif"],
                        "technical-sm": ["Space Grotesk", "Kantumruy Pro", "sans-serif"],
                        "technical-xs": ["Space Grotesk", "Kantumruy Pro", "sans-serif"],
                        "sans": ["Inter", "Kantumruy Pro", "sans-serif"]
                    },
                    fontSize: {
                        "headline-xl": ["48px", { lineHeight: "1.1", letterSpacing: "-0.02em", fontWeight: "800" }],
                        "headline-lg": ["32px", { lineHeight: "1.2", fontWeight: "700" }],
                        "headline-md": ["24px", { lineHeight: "1.3", fontWeight: "600" }],
                        "body-lg": ["18px", { lineHeight: "1.6", fontWeight: "400" }],
                        "body-md": ["16px", { lineHeight: "1.5", fontWeight: "400" }],
                        "technical-sm": ["14px", { lineHeight: "1.4", letterSpacing: "0.05em", fontWeight: "500" }],
                        "technical-xs": ["12px", { lineHeight: "1.2", fontWeight: "700" }]
                    }
                }
            }
        }
    </script>

    <style>
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-smoothing: antialiased;
        }
        .sketch-border { border-radius: 2px 255px 3px 25px / 255px 5px 225px 3px; }
        .pixel-border {
            clip-path: polygon(
                4px 0, calc(100% - 4px) 0,
                calc(100% - 4px) 4px, 100% 4px,
                100% calc(100% - 4px), calc(100% - 4px) calc(100% - 4px),
                calc(100% - 4px) 100%, 4px 100%,
                4px calc(100% - 4px), 0 calc(100% - 4px),
                0 4px, 4px 4px
            );
        }
        .wobbly-border {
            border-radius: 255px 15px 225px 15px/15px 225px 15px 255px;
            border: 2px solid #1E293B;
        }
        .pixel-shadow     { box-shadow: 4px 4px 0px 0px #1E293B; }
        .pixel-shadow-lg  { box-shadow: 8px 8px 0px 0px #1E293B; }
        .btn-hover:hover  { transform: translate(4px, 4px); box-shadow: none; }

        /* Kantumruy Pro — auto-fallback for any Khmer Unicode characters */

        /* Alpine.js cloak */
        [x-cloak] { display: none !important; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-on-background font-body-md antialiased min-h-screen flex">

    @include('layouts.navigation')

    <!-- Floating Monika Chat Button -->
    @auth
    @unless(request()->routeIs('chat.*'))
    <a href="{{ route('chat.index') }}"
       class="fixed bottom-6 right-6 z-50 flex items-center gap-3 px-4 py-3 bg-blue-600 text-white border-2 border-slate-900 shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] transition-all group">
        <div class="relative flex-shrink-0">
            <img src="/images/monika-logo.png" alt="Monika" class="w-9 h-9 object-cover rounded-full border-2 border-white">
            <span class="absolute -top-1 -right-1 w-3 h-3 bg-green-400 rounded-full border-2 border-slate-900 animate-pulse"></span>
        </div>
        <div class="flex flex-col leading-tight">
            <span class="font-technical-xs text-[9px] text-blue-200 uppercase tracking-widest">{{ __('Chat with') }}</span>
            <span class="font-technical-sm text-[13px] font-bold">Monika</span>
        </div>
        <span class="material-symbols-outlined text-[18px] text-blue-200 group-hover:text-white transition-colors">arrow_forward</span>
    </a>
    @endunless
    @endauth

    <!-- Main Content Area -->
    <div class="flex-grow md:ml-64 flex flex-col min-h-screen">
        <!-- Page Heading -->
        @isset($header)
            <div class="px-8 pt-8 pb-0">
                {{ $header }}
            </div>
        @endisset

        <!-- Page Content -->
        <main class="flex-grow p-8">
            {{ $slot }}
        </main>
    </div>

    <!-- Loading Overlay (logout) -->
    <div id="figco-loading" class="hidden fixed inset-0 z-[9999] flex items-center justify-center" style="background:rgba(15,23,42,0.88);">
        <div class="bg-white border-4 border-slate-900 shadow-[8px_8px_0px_0px_rgba(30,41,59,1)] px-10 py-8 flex flex-col items-center gap-5 sketch-border">
            <div class="relative">
                <img src="/images/monika-logo.png" alt="Monika" class="w-16 h-16 object-cover rounded-full border-2 border-slate-900">
                <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 border-2 border-slate-900 rounded-full animate-pulse"></span>
            </div>
            <div class="flex gap-2">
                <span class="w-3 h-3 bg-blue-600 border border-slate-900 rounded-full animate-bounce" style="animation-delay:0ms"></span>
                <span class="w-3 h-3 bg-blue-600 border border-slate-900 rounded-full animate-bounce" style="animation-delay:150ms"></span>
                <span class="w-3 h-3 bg-blue-600 border border-slate-900 rounded-full animate-bounce" style="animation-delay:300ms"></span>
            </div>
            <p class="font-technical-sm text-slate-900 uppercase tracking-widest" style="font-family:'Space Grotesk',sans-serif; font-size:12px;">{{ __('Signing out...') }}</p>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form[action*="logout"]').forEach(function(f) {
                f.addEventListener('submit', function() {
                    document.getElementById('figco-loading').classList.remove('hidden');
                });
            });
        });
    </script>
</body>
</html>
