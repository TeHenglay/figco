<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FigCo') }}</title>

    <!-- FigCo Design System Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100..900;1,100..900&family=Inter:opsz,wght@14..32,100..900&family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "surface": "#f9f9ff",
                        "surface-container-low": "#f0f3ff",
                        "surface-container": "#e7eeff",
                        "surface-container-high": "#dee8ff",
                        "on-surface": "#111c2d",
                        "on-surface-variant": "#424754",
                        "outline": "#727785",
                        "outline-variant": "#c2c6d6",
                        "surface-tint": "#005ac2",
                        "primary": "#0058be",
                        "on-primary": "#ffffff",
                        "primary-container": "#2170e4",
                        "on-primary-container": "#fefcff",
                        "primary-fixed": "#d8e2ff",
                        "on-primary-fixed": "#001a42",
                        "secondary-container": "#d3e5f1",
                        "error": "#ba1a1a",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a",
                        "background": "#f9f9ff",
                        "on-background": "#111c2d",
                        "surface-variant": "#d8e3fb",
                    },
                    fontFamily: {
                        "headline-xl": ["Epilogue"],
                        "headline-lg": ["Epilogue"],
                        "headline-md": ["Epilogue"],
                        "body-lg": ["Inter"],
                        "body-md": ["Inter"],
                        "technical-sm": ["Space Grotesk"],
                        "technical-xs": ["Space Grotesk"],
                        "sans": ["Inter"]
                    },
                    fontSize: {
                        "headline-xl": ["48px", { lineHeight: "1.1", letterSpacing: "-0.02em", fontWeight: "800" }],
                        "headline-lg": ["32px", { lineHeight: "1.2", fontWeight: "700" }],
                        "headline-md": ["24px", { lineHeight: "1.3", fontWeight: "600" }],
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
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-on-background font-body-md antialiased min-h-screen relative overflow-x-hidden">

    <!-- Background dither pattern -->
    <div class="fixed inset-0 pointer-events-none opacity-[0.025] z-0" style="background-image: radial-gradient(#111c2d 2px, transparent 2px); background-size: 16px 16px;"></div>

    <!-- Blueprint grid accent -->
    <div class="fixed inset-0 pointer-events-none opacity-[0.04] z-0" style="background-image: linear-gradient(#0058be 1px, transparent 1px), linear-gradient(90deg, #0058be 1px, transparent 1px); background-size: 40px 40px;"></div>

    <!-- Decorative corner element -->
    <div class="fixed top-6 left-6 opacity-20 pointer-events-none hidden lg:block z-0">
        <div class="w-24 h-24 border-4 border-primary sketch-border"></div>
        <div class="w-16 h-16 border-4 border-primary sketch-border absolute top-4 left-4"></div>
    </div>
    <div class="fixed bottom-6 right-6 opacity-20 pointer-events-none hidden lg:block z-0">
        <div class="w-24 h-24 border-4 border-surface-tint sketch-border"></div>
    </div>

    <div class="relative z-10 min-h-screen flex flex-col items-center justify-center px-4 py-12">

        <!-- Brand Logo -->
        <a href="/" class="mb-8 flex flex-col items-center gap-2 group">
            <div class="border-4 border-slate-900 bg-white p-1 shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] group-hover:translate-x-[2px] group-hover:translate-y-[2px] group-hover:shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] transition-all sketch-border">
                <img src="/logo/logo-figco.png" alt="FigCo" class="h-16 w-auto object-contain" />
            </div>
            <img src="/logo/FIGCO.png" alt="FigCo" class="h-9 w-auto object-contain" />
            <span class="font-technical-xs text-technical-xs text-outline uppercase tracking-widest">Blueprint Mode</span>
        </a>

        <!-- Auth Card -->
        <div class="w-full max-w-md">
            <div class="bg-white border-2 border-slate-900 shadow-[8px_8px_0px_0px_rgba(30,41,59,1)] sketch-border overflow-hidden">
                <!-- Card top accent bar -->
                <div class="h-2 bg-primary"></div>
                <div class="p-8">
                    {{ $slot }}
                </div>
            </div>

            <!-- Decorative tag sticker -->
            <div class="mt-4 flex justify-end">
                <div class="border-2 border-slate-900 bg-[#FFD700] px-3 py-1 font-technical-xs text-technical-xs text-slate-900 shadow-[3px_3px_0px_0px_rgba(30,41,59,1)] rotate-[-2deg] sketch-border">
                    Draw Your Code Into Reality
                </div>
            </div>
        </div>

    </div>
</body>
</html>
