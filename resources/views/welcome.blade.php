<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>FigCo - Draw Your Code Into Reality</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100..900;1,100..900&family=Inter:opsz,wght@14..32,100..900&family=Space+Grotesk:wght@300..700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
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
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }
        .sketch-border {
            border-radius: 2px 255px 3px 25px / 255px 5px 225px 3px;
        }
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
        .quote-bubble-border {
            border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px;
        }
    </style>
    <script id="tailwind-config">
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
                        "headline-xl": ["Epilogue"],
                        "headline-lg": ["Epilogue"],
                        "headline-md": ["Epilogue"],
                        "body-lg": ["Inter"],
                        "body-md": ["Inter"],
                        "technical-sm": ["Space Grotesk"],
                        "technical-xs": ["Space Grotesk"]
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
</head>
<body class="bg-background text-on-background min-h-screen flex flex-col font-body-md overflow-x-hidden selection:bg-primary-container selection:text-on-primary-container relative">

    <!-- Subtle Background Dither Pattern -->
    <div class="fixed inset-0 pointer-events-none opacity-[0.03] z-[-1]" style="background-image: radial-gradient(#111c2d 2px, transparent 2px); background-size: 16px 16px;"></div>

    <!-- Navigation -->
    <nav class="bg-white border-2 border-slate-900 m-4 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] sticky top-0 z-50 flex justify-between items-center px-6 py-3 max-w-7xl mx-auto w-[calc(100%-2rem)] sketch-border">
        <a class="hover:-translate-y-1 hover:translate-x-1 transition-transform flex items-center gap-0" href="{{ url('/') }}">
            <img src="/logo/logo-figco-tran.png" alt="" class="h-14 w-auto object-contain" />
            <img src="/logo/FIGCO.png" alt="FigCo" class="h-14 w-auto object-contain" />
        </a>

        <!-- Desktop Nav -->
        <div class="hidden md:flex items-center gap-8">
            <a class="text-slate-600 font-medium font-body-md hover:-translate-y-[2px] hover:text-primary transition-all" href="#features">Features</a>
            <a class="text-slate-600 font-medium font-body-md hover:-translate-y-[2px] hover:text-primary transition-all" href="#docs">Docs</a>
            <a class="text-slate-600 font-medium font-body-md hover:-translate-y-[2px] hover:text-primary transition-all" href="#community">Community</a>
            <a class="text-slate-600 font-medium font-body-md hover:-translate-y-[2px] hover:text-primary transition-all" href="#pricing">Pricing</a>
        </div>

        <div class="hidden md:flex items-center gap-3">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="border-2 border-slate-900 bg-surface-container-low text-on-surface px-4 py-2 font-technical-xs font-bold shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all duration-75 sketch-border inline-flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">dashboard</span>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-slate-600 font-medium font-technical-sm hover:-translate-y-[2px] hover:text-primary transition-all">
                        Log In
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="border-2 border-slate-900 bg-primary-container text-on-primary-container px-4 py-2 font-technical-xs font-bold shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all duration-75 sketch-border">
                            Start Drawing Code
                        </a>
                    @endif
                @endauth
            @endif
        </div>

        <!-- Mobile Menu Icon -->
        <button class="md:hidden text-slate-900">
            <span class="material-symbols-outlined text-[32px]">menu</span>
        </button>
    </nav>

    <main class="flex-grow w-full mx-auto flex flex-col">

        <!-- Hero Section -->
        <section class="max-w-7xl mx-auto px-4 md:px-8 py-12 md:py-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center w-full">
            <div class="flex flex-col gap-8 order-2 lg:order-1 relative">
                <!-- Decorative doodle behind text -->
                <div class="absolute -top-10 -left-10 w-32 h-32 border-4 border-surface-tint rounded-full opacity-20 sketch-border z-[-1]"></div>

                <h1 class="font-headline-xl text-headline-xl text-on-background relative">
                    <span class="relative z-10">Draw Your Code</span><br/>
                    <span class="relative z-10">Into Reality.</span>
                    <!-- Hand-drawn underline effect -->
                    <svg class="absolute bottom-[-10px] left-0 w-full h-4 text-primary z-0" preserveAspectRatio="none" viewBox="0 0 100 10">
                        <path class="sketch-border" d="M0 5 Q 50 10 100 2" fill="none" stroke="currentColor" stroke-width="3"/>
                    </svg>
                </h1>

                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-lg">
                    Turn your messy, creative Figma frames into structured, 8-bit perfect React and Vue code. The bridge between raw imagination and technical precision is finally here.
                </p>

                <div class="flex flex-col sm:flex-row gap-6 mt-4">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="border-2 border-slate-900 bg-surface-tint text-on-primary px-8 py-4 font-technical-sm text-technical-sm font-bold shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none transition-all duration-75 active:scale-95 sketch-border flex items-center justify-center gap-2 w-fit">
                            <span class="material-symbols-outlined">code_blocks</span>
                            Start Drawing Code
                        </a>
                    @endif
                    <button class="border-2 border-slate-900 bg-surface text-on-surface px-8 py-4 font-technical-sm text-technical-sm font-bold shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none transition-all duration-75 active:scale-95 sketch-border flex items-center justify-center gap-2 w-fit">
                        <span class="material-symbols-outlined">play_arrow</span>
                        Watch Demo
                    </button>
                </div>
            </div>

            <div class="order-1 lg:order-2 flex justify-center relative">
                <!-- The "Sketch to Code" Illustration Container -->
                <div class="relative w-full max-w-lg aspect-square border-4 border-slate-900 bg-white shadow-[12px_12px_0px_0px_rgba(30,41,59,1)] sketch-border overflow-hidden p-4 group">
                    <!-- Blueprint grid background -->
                    <div class="absolute inset-0 opacity-10" style="background-image: linear-gradient(#0058be 1px, transparent 1px), linear-gradient(90deg, #0058be 1px, transparent 1px); background-size: 24px 24px;"></div>

                    <!-- Simulated sketch-to-code illustration -->
                    <div class="relative w-full h-full flex items-center justify-center">
                        <!-- Left: Wireframe sketch -->
                        <div class="absolute left-4 top-4 bottom-4 w-[42%] border-2 border-slate-400 bg-white sketch-border p-3 flex flex-col gap-2">
                            <div class="w-full h-4 bg-slate-200 border border-slate-400 sketch-border"></div>
                            <div class="w-3/4 h-3 bg-slate-100 border border-slate-300 sketch-border"></div>
                            <div class="grid grid-cols-2 gap-1 mt-2">
                                <div class="h-12 bg-blue-100 border border-slate-400 sketch-border"></div>
                                <div class="h-12 bg-blue-50 border border-slate-400 sketch-border"></div>
                            </div>
                            <div class="w-full h-3 bg-slate-100 border border-slate-300 sketch-border mt-1"></div>
                            <div class="w-2/3 h-3 bg-slate-100 border border-slate-300 sketch-border"></div>
                            <div class="w-1/2 h-6 bg-primary border-2 border-slate-900 sketch-border mt-auto"></div>
                            <p class="text-center font-technical-xs text-technical-xs text-slate-400 uppercase tracking-wider">Sketch</p>
                        </div>

                        <!-- Arrow -->
                        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-8 flex flex-col items-center gap-1 z-10">
                            <div class="w-[2px] h-6 bg-slate-900"></div>
                            <div class="border-2 border-slate-900 bg-yellow-300 p-1 pixel-border">
                                <span class="material-symbols-outlined text-[16px] text-slate-900">arrow_forward</span>
                            </div>
                            <div class="w-[2px] h-6 bg-slate-900"></div>
                        </div>

                        <!-- Right: Code output -->
                        <div class="absolute right-4 top-4 bottom-4 w-[42%] border-2 border-slate-900 bg-slate-900 sketch-border p-3 flex flex-col gap-1 overflow-hidden">
                            <p class="font-technical-xs text-[10px] text-green-400">&lt;div className="card"&gt;</p>
                            <p class="font-technical-xs text-[10px] text-blue-300 pl-2">&lt;Header /&gt;</p>
                            <p class="font-technical-xs text-[10px] text-yellow-300 pl-2">&lt;Grid cols=2&gt;</p>
                            <p class="font-technical-xs text-[10px] text-pink-300 pl-4">&lt;Card /&gt;</p>
                            <p class="font-technical-xs text-[10px] text-pink-300 pl-4">&lt;Card /&gt;</p>
                            <p class="font-technical-xs text-[10px] text-yellow-300 pl-2">&lt;/Grid&gt;</p>
                            <p class="font-technical-xs text-[10px] text-blue-300 pl-2">&lt;Button /&gt;</p>
                            <p class="font-technical-xs text-[10px] text-green-400">&lt;/div&gt;</p>
                            <div class="mt-auto w-2 h-4 bg-green-400 animate-pulse"></div>
                            <p class="text-center font-technical-xs text-[10px] text-slate-400 uppercase tracking-wider">Code</p>
                        </div>
                    </div>

                    <!-- Overlay to enforce brand color slightly -->
                    <div class="absolute inset-0 bg-primary mix-blend-screen opacity-10 pointer-events-none"></div>

                    <!-- Floating UI elements -->
                    <div class="absolute top-8 -left-4 border-2 border-slate-900 bg-[#FFD700] px-3 py-1 font-technical-xs text-slate-900 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] rotate-[-6deg] sketch-border text-technical-xs">
                        Frame_1
                    </div>
                    <div class="absolute bottom-12 -right-6 border-2 border-slate-900 bg-[#FF6B6B] px-3 py-1 font-technical-xs text-white shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] rotate-[12deg] pixel-border text-technical-xs">
                        &lt;div /&gt;
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="w-full bg-surface-container-low py-20 border-y-4 border-dashed border-outline-variant mt-12">
            <div class="max-w-7xl mx-auto px-4 md:px-8 flex flex-col gap-12">
                <div class="flex flex-col items-center text-center gap-4">
                    <h2 class="font-headline-lg text-headline-lg text-on-background">Tools of the Trade</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">Everything you need to turn raw ideas into robust architecture.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-surface border-2 border-slate-900 p-8 shadow-[8px_8px_0px_0px_rgba(30,41,59,1)] sketch-border flex flex-col gap-4 group hover:-translate-y-1 transition-transform">
                        <div class="w-16 h-16 rounded-full border-2 border-slate-900 bg-secondary-container flex items-center justify-center text-on-secondary-container sketch-border mb-2 group-hover:rotate-12 transition-transform">
                            <span class="material-symbols-outlined text-[32px]">code</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-background">Multi-framework Support</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Export to React, Vue, Svelte, or plain HTML/Tailwind with a single click. Your stack, your rules.</p>
                    </div>
                    <div class="bg-surface border-2 border-slate-900 p-8 shadow-[8px_8px_0px_0px_rgba(30,41,59,1)] sketch-border flex flex-col gap-4 group hover:-translate-y-1 transition-transform">
                        <div class="w-16 h-16 rounded-full border-2 border-slate-900 bg-primary-fixed flex items-center justify-center text-on-primary-fixed sketch-border mb-2 group-hover:rotate-12 transition-transform">
                            <span class="material-symbols-outlined text-[32px]">sync</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-background">Real-time Sync</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Update your Figma file and watch your code update instantly. No more tedious manual adjustments.</p>
                    </div>
                    <div class="bg-surface border-2 border-slate-900 p-8 shadow-[8px_8px_0px_0px_rgba(30,41,59,1)] sketch-border flex flex-col gap-4 group hover:-translate-y-1 transition-transform">
                        <div class="w-16 h-16 rounded-full border-2 border-slate-900 bg-tertiary-container flex items-center justify-center text-on-tertiary-container sketch-border mb-2 group-hover:rotate-12 transition-transform">
                            <span class="material-symbols-outlined text-[32px]">imagesmode</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-background">Optimized Assets</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Automatic image optimization, SVG extraction, and sprite generation for blazing-fast load times.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Blueprint Workflow Section -->
        <section id="docs" class="w-full max-w-7xl mx-auto px-4 md:px-8 py-20 flex flex-col gap-12 relative">
            <div class="flex flex-col items-center text-center gap-4">
                <h2 class="font-headline-lg text-headline-lg text-on-background">The Blueprint Workflow</h2>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">Three brutal steps to turn your sketches into production-ready syntax.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                <!-- Hand-drawn SVG Connectors (Desktop only) -->
                <svg class="hidden md:block absolute top-1/2 left-[25%] w-[16%] h-16 -translate-y-1/2 z-0 text-slate-900 pointer-events-none" preserveAspectRatio="none" viewBox="0 0 100 20">
                    <path d="M0 10 Q 50 -10 100 10" fill="none" stroke="currentColor" stroke-dasharray="4 4" stroke-width="2"/>
                    <polygon fill="currentColor" points="95,5 100,10 95,15"/>
                </svg>
                <svg class="hidden md:block absolute top-1/2 left-[58%] w-[16%] h-16 -translate-y-1/2 z-0 text-slate-900 pointer-events-none" preserveAspectRatio="none" viewBox="0 0 100 20">
                    <path d="M0 10 Q 50 30 100 10" fill="none" stroke="currentColor" stroke-dasharray="4 4" stroke-width="2"/>
                    <polygon fill="currentColor" points="95,5 100,10 95,15"/>
                </svg>

                <!-- Step 1 -->
                <div class="bg-surface-container-lowest border-2 border-slate-900 p-8 shadow-[8px_8px_0px_0px_rgba(30,41,59,1)] hover:-translate-y-2 hover:translate-x-2 hover:shadow-[0px_0px_0px_0px_rgba(30,41,59,1)] transition-all duration-200 sketch-border flex flex-col gap-6 relative group z-10">
                    <div class="w-16 h-16 bg-secondary-container border-2 border-slate-900 flex items-center justify-center pixel-border text-on-secondary-container">
                        <span class="material-symbols-outlined text-[32px]">content_paste_go</span>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h3 class="font-headline-md text-headline-md text-on-background">1. Paste Figma URL</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Drop your link. We parse the layers, identify the wobbly bits, and prepare the grid structure.</p>
                    </div>
                    <div class="absolute top-4 right-4 text-outline font-technical-xs text-technical-xs opacity-50 group-hover:opacity-100 group-hover:text-primary transition-colors">01</div>
                </div>

                <!-- Step 2 -->
                <div class="bg-surface-container-low border-2 border-slate-900 p-8 shadow-[8px_8px_0px_0px_rgba(30,41,59,1)] hover:-translate-y-2 hover:translate-x-2 hover:shadow-[0px_0px_0px_0px_rgba(30,41,59,1)] transition-all duration-200 sketch-border flex flex-col gap-6 relative group md:-translate-y-4 z-10">
                    <div class="w-16 h-16 bg-primary-fixed border-2 border-slate-900 flex items-center justify-center pixel-border text-on-primary-fixed">
                        <span class="material-symbols-outlined text-[32px]">settings</span>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h3 class="font-headline-md text-headline-md text-on-background">2. Choose Framework</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Select React, Vue, or raw HTML/Tailwind. We map your design tokens to our rigid 8-bit logic engine.</p>
                    </div>
                    <div class="absolute top-4 right-4 text-outline font-technical-xs text-technical-xs opacity-50 group-hover:opacity-100 group-hover:text-primary transition-colors">02</div>
                </div>

                <!-- Step 3 -->
                <div class="bg-surface-container-lowest border-2 border-slate-900 p-8 shadow-[8px_8px_0px_0px_rgba(30,41,59,1)] hover:-translate-y-2 hover:translate-x-2 hover:shadow-[0px_0px_0px_0px_rgba(30,41,59,1)] transition-all duration-200 sketch-border flex flex-col gap-6 relative group z-10">
                    <div class="w-16 h-16 bg-tertiary-container border-2 border-slate-900 flex items-center justify-center pixel-border text-on-tertiary-container">
                        <span class="material-symbols-outlined text-[32px]">data_object</span>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h3 class="font-headline-md text-headline-md text-on-background">3. Instant Code</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Copy the clean, semantic code. It's mathematically sound, technically precise, and ready to deploy.</p>
                    </div>
                    <div class="absolute top-4 right-4 text-outline font-technical-xs text-technical-xs opacity-50 group-hover:opacity-100 group-hover:text-primary transition-colors">03</div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section id="community" class="w-full bg-slate-900 text-white py-20 border-y-4 border-slate-900 sketch-border -skew-y-1 my-12">
            <div class="max-w-7xl mx-auto px-4 md:px-8 flex flex-col gap-16 skew-y-1">
                <div class="flex flex-col items-center text-center gap-4">
                    <h2 class="font-headline-lg text-headline-lg text-white">Loved by Builders</h2>
                    <p class="font-body-md text-body-md text-slate-300 max-w-2xl">Don't just take our word for it. See what the community is drawing.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                    <div class="relative bg-white text-slate-900 p-8 shadow-[8px_8px_0px_0px_#adc6ff] quote-bubble-border flex flex-col gap-6">
                        <p class="font-body-lg text-body-lg italic">"FigCo completely changed how we hand off designs. It feels like magic, but the code is actually readable and performant."</p>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-primary-fixed border-2 border-slate-900 pixel-border flex items-center justify-center">
                                <span class="material-symbols-outlined text-on-primary-fixed">person</span>
                            </div>
                            <div>
                                <h4 class="font-headline-md text-[18px] font-bold">Sarah Drasner</h4>
                                <p class="font-technical-xs text-technical-xs text-slate-500 uppercase">Frontend Lead</p>
                            </div>
                        </div>
                    </div>
                    <div class="relative bg-white text-slate-900 p-8 shadow-[8px_8px_0px_0px_#ffdad6] quote-bubble-border flex flex-col gap-6 md:translate-y-8">
                        <p class="font-body-lg text-body-lg italic">"I sketched a dashboard on a napkin, put it in Figma, and had a working Vue prototype in 10 minutes. Absolute game-changer."</p>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-secondary-fixed-dim border-2 border-slate-900 pixel-border flex items-center justify-center">
                                <span class="material-symbols-outlined text-on-secondary-fixed">person</span>
                            </div>
                            <div>
                                <h4 class="font-headline-md text-[18px] font-bold">Mark Otto</h4>
                                <p class="font-technical-xs text-technical-xs text-slate-500 uppercase">UX Engineer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="pricing" class="w-full max-w-7xl mx-auto px-4 md:px-8 py-20 flex flex-col gap-12">
            <div class="flex flex-col items-center text-center gap-4">
                <h2 class="font-headline-lg text-headline-lg text-on-background">Simple Pricing</h2>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">No subscriptions. No surprises. Pay for what you generate.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Free -->
                <div class="bg-surface border-2 border-slate-900 p-8 shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] sketch-border flex flex-col gap-4">
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-1 border-2 border-slate-900 font-technical-xs text-technical-xs uppercase bg-surface-container-low">Free</span>
                    </div>
                    <p class="font-headline-xl text-headline-xl text-slate-900" style="font-family: Epilogue, sans-serif;">$0<span class="font-body-md text-body-md text-slate-500 text-base">/mo</span></p>
                    <p class="font-body-md text-body-md text-slate-600 text-sm">Perfect for solo exploration and prototyping.</p>
                    <ul class="flex flex-col gap-2 mt-2">
                        @foreach(['5 component generations/mo', '1 active project', 'React & Vue support', 'Community support'] as $feat)
                            <li class="flex items-center gap-2 font-technical-xs text-technical-xs text-slate-700">
                                <span class="material-symbols-outlined text-[16px] text-green-600">check</span>{{ $feat }}
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('register') }}" class="mt-auto border-2 border-slate-900 px-5 py-3 font-technical-xs text-technical-xs uppercase font-bold text-center hover:bg-surface-container-low transition-colors">
                        Get Started Free
                    </a>
                </div>
                <!-- Pro -->
                <div class="bg-primary text-on-primary border-2 border-slate-900 p-8 shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] sketch-border flex flex-col gap-4 relative -translate-y-3">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-yellow-300 border-2 border-slate-900 px-3 py-1 font-technical-xs text-technical-xs uppercase text-slate-900 font-bold">Most Popular</div>
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-1 border-2 border-white/50 font-technical-xs text-technical-xs uppercase bg-white/10">Pro</span>
                    </div>
                    <p class="font-headline-xl text-headline-xl" style="font-family: Epilogue, sans-serif;">$19<span class="font-body-md text-body-md opacity-70 text-base">/mo</span></p>
                    <p class="font-body-md text-body-md opacity-80 text-sm">For teams shipping fast and scaling ideas.</p>
                    <ul class="flex flex-col gap-2 mt-2">
                        @foreach(['200 component generations/mo', 'Unlimited projects', 'React, Vue & more', 'Priority support', 'Export to GitHub'] as $feat)
                            <li class="flex items-center gap-2 font-technical-xs text-technical-xs">
                                <span class="material-symbols-outlined text-[16px]">check</span>{{ $feat }}
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('register') }}" class="mt-auto border-2 border-white bg-white text-primary px-5 py-3 font-technical-xs text-technical-xs uppercase font-bold text-center hover:bg-blue-50 transition-colors shadow-[4px_4px_0px_0px_rgba(255,255,255,0.4)]">
                        Start Pro Trial
                    </a>
                </div>
                <!-- Enterprise -->
                <div class="bg-slate-900 text-white border-2 border-slate-900 p-8 shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] sketch-border flex flex-col gap-4">
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-1 border-2 border-white/20 font-technical-xs text-technical-xs uppercase bg-white/10">Enterprise</span>
                    </div>
                    <p class="font-headline-xl text-headline-xl" style="font-family: Epilogue, sans-serif;">Custom</p>
                    <p class="font-body-md text-body-md opacity-70 text-sm">Tailored limits, SSO, and dedicated support.</p>
                    <ul class="flex flex-col gap-2 mt-2">
                        @foreach(['Unlimited generations', 'Custom integrations', 'SSO / SAML', 'SLA + Dedicated support', 'On-prem option'] as $feat)
                            <li class="flex items-center gap-2 font-technical-xs text-technical-xs text-slate-300">
                                <span class="material-symbols-outlined text-[16px] text-yellow-400">check</span>{{ $feat }}
                            </li>
                        @endforeach
                    </ul>
                    <a href="mailto:hello@figco.dev" class="mt-auto border-2 border-white/50 px-5 py-3 font-technical-xs text-technical-xs uppercase font-bold text-center hover:border-white hover:bg-white/10 transition-colors">
                        Contact Sales
                    </a>
                </div>
            </div>
        </section>

        <!-- Final CTA Section -->
        <section class="w-full max-w-4xl mx-auto px-4 md:px-8 py-24 flex flex-col items-center text-center gap-8">
            <div class="w-24 h-24 bg-[#FFD700] border-4 border-slate-900 rounded-full flex items-center justify-center sketch-border animate-bounce mb-4 shadow-[8px_8px_0px_0px_rgba(30,41,59,1)]">
                <span class="material-symbols-outlined text-[48px] text-slate-900">rocket_launch</span>
            </div>
            <h2 class="font-headline-xl text-headline-xl text-on-background">Ready to Build?</h2>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl">
                Join thousands of developers and designers turning their ideas into reality faster than ever.
            </p>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="mt-4 border-4 border-slate-900 bg-primary text-on-primary px-10 py-5 text-xl font-technical-sm font-bold shadow-[8px_8px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none transition-all duration-75 active:scale-95 sketch-border inline-flex items-center justify-center gap-3">
                    <span class="material-symbols-outlined">terminal</span>
                    Start Drawing Code Now
                </a>
            @endif
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-blue-50 border-t-4 border-slate-900 mt-20 w-full pt-16 pb-8 px-8 flex flex-col gap-12 sketch-border relative overflow-hidden">
        <div class="max-w-7xl mx-auto w-full grid grid-cols-1 md:grid-cols-4 gap-8 relative z-10">
            <div class="flex flex-col gap-4">
                <span class="font-black text-2xl text-slate-900 font-headline-md italic">FigCo</span>
                <p class="font-body-md text-body-md text-slate-600">Bridging the gap between raw imagination and technical precision.</p>
            </div>
            <div class="flex flex-col gap-4">
                <h4 class="font-technical-xs font-bold uppercase tracking-widest text-slate-900">Product</h4>
                <a class="text-slate-500 hover:text-blue-500 font-body-md transition-colors" href="#">Features</a>
                <a class="text-slate-500 hover:text-blue-500 font-body-md transition-colors" href="#">Integrations</a>
                <a class="text-slate-500 hover:text-blue-500 font-body-md transition-colors" href="#">Pricing</a>
                <a class="text-slate-500 hover:text-blue-500 font-body-md transition-colors" href="#">Changelog</a>
            </div>
            <div class="flex flex-col gap-4">
                <h4 class="font-technical-xs font-bold uppercase tracking-widest text-slate-900">Resources</h4>
                <a class="text-slate-500 hover:text-blue-500 font-body-md transition-colors" href="#">Documentation</a>
                <a class="text-slate-500 hover:text-blue-500 font-body-md transition-colors" href="#">API Reference</a>
                <a class="text-slate-500 hover:text-blue-500 font-body-md transition-colors" href="#">Community Forum</a>
                <a class="text-slate-500 hover:text-blue-500 font-body-md transition-colors" href="#">Blog</a>
            </div>
            <div class="flex flex-col gap-4">
                <h4 class="font-technical-xs font-bold uppercase tracking-widest text-slate-900">Legal</h4>
                <a class="text-slate-500 hover:text-blue-500 font-body-md transition-colors" href="#">Privacy Policy</a>
                <a class="text-slate-500 hover:text-blue-500 font-body-md transition-colors" href="#">Terms of Service</a>
                <a class="text-slate-500 hover:text-blue-500 font-body-md transition-colors" href="#">Cookie Policy</a>
            </div>
        </div>
        <div class="max-w-7xl mx-auto w-full pt-8 border-t-2 border-dashed border-slate-300 flex flex-col md:flex-row justify-between items-center gap-4 relative z-10">
            <span class="font-technical-xs text-technical-xs uppercase tracking-widest text-slate-900">© {{ date('Y') }} FigCo - Drawn with Logic.</span>
            <div class="flex gap-6 font-technical-xs text-technical-xs uppercase tracking-widest">
                <a class="text-slate-500 hover:text-blue-500 underline transition-colors duration-200" href="#">GitHub</a>
                <a class="text-slate-500 hover:text-blue-500 underline transition-colors duration-200" href="#">Discord</a>
                <a class="text-slate-500 hover:text-blue-500 underline transition-colors duration-200" href="#">Twitter</a>
            </div>
        </div>
        <!-- 8-bit Mascot -->
        <div class="absolute right-8 bottom-[-10px] opacity-20 pointer-events-none transform scale-150 text-slate-900 hidden md:block">
            <span class="material-symbols-outlined text-[100px]" style="font-variation-settings: 'FILL' 1;">smart_toy</span>
        </div>
    </footer>

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (!target) return;
                e.preventDefault();

                const start = window.scrollY;
                const end = target.getBoundingClientRect().top + window.scrollY - 80;
                const distance = end - start;
                const duration = 800;
                let startTime = null;

                function easeInOutCubic(t) {
                    return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
                }

                function step(timestamp) {
                    if (!startTime) startTime = timestamp;
                    const elapsed = timestamp - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    window.scrollTo(0, start + distance * easeInOutCubic(progress));
                    if (progress < 1) requestAnimationFrame(step);
                }

                requestAnimationFrame(step);
            });
        });
    </script>

</body>
</html>
