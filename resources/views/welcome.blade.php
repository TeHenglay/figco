<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>FigCo — AI Teacher Assistant</title>
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
        .quote-bubble-border { border-radius: 255px 15px 225px 15px / 15px 225px 15px 255px; }
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

    <!-- Background dither -->
    <div class="fixed inset-0 pointer-events-none opacity-[0.03] z-[-1]" style="background-image: radial-gradient(#111c2d 2px, transparent 2px); background-size: 16px 16px;"></div>

    <!-- Navigation -->
    <nav class="bg-white border-2 border-slate-900 m-4 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] sticky top-0 z-50 flex justify-between items-center px-6 py-3 max-w-7xl mx-auto w-[calc(100%-2rem)] sketch-border">
        <a class="hover:-translate-y-1 hover:translate-x-1 transition-transform flex items-center gap-0" href="{{ url('/') }}">
            <img src="/logo/logo-figco-tran.png" alt="" class="h-14 w-auto object-contain" />
            <img src="/logo/FIGCO.png" alt="FigCo" class="h-14 w-auto object-contain" />
        </a>

        <div class="hidden md:flex items-center gap-8">
            <a class="text-slate-600 font-medium font-body-md hover:-translate-y-[2px] hover:text-primary transition-all" href="#features">Features</a>
            <a class="text-slate-600 font-medium font-body-md hover:-translate-y-[2px] hover:text-primary transition-all" href="#how-it-works">How It Works</a>
            <a class="text-slate-600 font-medium font-body-md hover:-translate-y-[2px] hover:text-primary transition-all" href="#testimonials">Reviews</a>
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
                            Get Started Free
                        </a>
                    @endif
                @endauth
            @endif
        </div>

        <button class="md:hidden text-slate-900">
            <span class="material-symbols-outlined text-[32px]">menu</span>
        </button>
    </nav>

    <main class="flex-grow w-full mx-auto flex flex-col">

        <!-- Hero -->
        <section class="max-w-7xl mx-auto px-4 md:px-8 py-12 md:py-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center w-full">
            <div class="flex flex-col gap-8 order-2 lg:order-1 relative">
                <div class="absolute -top-10 -left-10 w-32 h-32 border-4 border-surface-tint rounded-full opacity-20 sketch-border z-[-1]"></div>

                <div class="flex items-center gap-2 w-fit border-2 border-slate-900 bg-yellow-300 px-3 py-1 font-technical-xs text-slate-900 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] sketch-border">
                    <span class="material-symbols-outlined text-[16px]">auto_awesome</span>
                    Powered by Google Gemini AI
                </div>

                <h1 class="font-headline-xl text-headline-xl text-on-background relative">
                    <span class="relative z-10">Your AI-Powered</span><br/>
                    <span class="relative z-10">Teaching Sidekick.</span>
                    <svg class="absolute bottom-[-10px] left-0 w-full h-4 text-primary z-0" preserveAspectRatio="none" viewBox="0 0 100 10">
                        <path d="M0 5 Q 50 10 100 2" fill="none" stroke="currentColor" stroke-width="3"/>
                    </svg>
                </h1>

                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-lg">
                    Chat with an AI assistant for lesson planning and ideas. Upload a lesson PDF and get a complete, ready-to-download homework assignment in seconds.
                </p>

                <div class="flex flex-col sm:flex-row gap-6 mt-4">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="border-2 border-slate-900 bg-surface-tint text-on-primary px-8 py-4 font-technical-sm text-technical-sm font-bold shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none transition-all duration-75 active:scale-95 sketch-border flex items-center justify-center gap-2 w-fit">
                            <span class="material-symbols-outlined">school</span>
                            Start Teaching Smarter
                        </a>
                    @endif
                    <a href="#how-it-works" class="border-2 border-slate-900 bg-surface text-on-surface px-8 py-4 font-technical-sm text-technical-sm font-bold shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none transition-all duration-75 active:scale-95 sketch-border flex items-center justify-center gap-2 w-fit">
                        <span class="material-symbols-outlined">play_arrow</span>
                        See How It Works
                    </a>
                </div>
            </div>

            <!-- Hero Illustration -->
            <div class="order-1 lg:order-2 flex justify-center relative">
                <div class="relative w-full max-w-lg aspect-square border-4 border-slate-900 bg-white shadow-[12px_12px_0px_0px_rgba(30,41,59,1)] sketch-border overflow-hidden p-4 group">
                    <div class="absolute inset-0 opacity-10" style="background-image: linear-gradient(#0058be 1px, transparent 1px), linear-gradient(90deg, #0058be 1px, transparent 1px); background-size: 24px 24px;"></div>

                    <div class="relative w-full h-full flex items-center justify-center">
                        <!-- Chat UI mockup -->
                        <div class="absolute left-4 top-4 bottom-4 w-[42%] border-2 border-slate-400 bg-white sketch-border p-3 flex flex-col gap-2 overflow-hidden">
                            <div class="w-full h-4 bg-blue-100 border border-slate-400 sketch-border flex items-center px-1">
                                <span class="text-[8px] text-blue-700 font-bold">AI Assistant</span>
                            </div>
                            <div class="flex flex-col gap-1 mt-1">
                                <div class="self-end w-3/4 h-5 bg-blue-500 border border-slate-400 sketch-border"></div>
                                <div class="self-start w-full h-8 bg-slate-100 border border-slate-300 sketch-border"></div>
                                <div class="self-end w-2/3 h-5 bg-blue-500 border border-slate-400 sketch-border"></div>
                                <div class="self-start w-full h-5 bg-slate-100 border border-slate-300 sketch-border"></div>
                            </div>
                            <div class="mt-auto w-full h-5 bg-slate-200 border border-slate-400 sketch-border"></div>
                            <p class="text-center font-bold text-[8px] text-slate-400 uppercase tracking-wider">AI Chat</p>
                        </div>

                        <!-- Arrow -->
                        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-8 flex flex-col items-center gap-1 z-10">
                            <div class="w-[2px] h-6 bg-slate-900"></div>
                            <div class="border-2 border-slate-900 bg-yellow-300 p-1 pixel-border">
                                <span class="material-symbols-outlined text-[16px] text-slate-900">arrow_forward</span>
                            </div>
                            <div class="w-[2px] h-6 bg-slate-900"></div>
                        </div>

                        <!-- Homework output mockup -->
                        <div class="absolute right-4 top-4 bottom-4 w-[42%] border-2 border-slate-900 bg-white sketch-border p-3 flex flex-col gap-1 overflow-hidden">
                            <div class="w-full h-4 bg-green-100 border border-green-400 sketch-border flex items-center px-1">
                                <span class="text-[8px] text-green-700 font-bold">Homework.pdf</span>
                            </div>
                            <div class="w-full h-2 bg-slate-200 border border-slate-300 sketch-border mt-1"></div>
                            <div class="w-3/4 h-2 bg-slate-200 border border-slate-300 sketch-border"></div>
                            <div class="w-full h-2 bg-slate-100 border border-slate-200 sketch-border mt-1"></div>
                            <div class="w-full h-2 bg-slate-100 border border-slate-200 sketch-border"></div>
                            <div class="w-2/3 h-2 bg-slate-100 border border-slate-200 sketch-border"></div>
                            <div class="w-full h-2 bg-slate-100 border border-slate-200 sketch-border mt-1"></div>
                            <div class="mt-auto flex gap-1">
                                <div class="flex-1 h-5 bg-red-500 border border-slate-900 sketch-border flex items-center justify-center">
                                    <span class="text-[7px] text-white font-bold">PDF</span>
                                </div>
                                <div class="flex-1 h-5 bg-blue-500 border border-slate-900 sketch-border flex items-center justify-center">
                                    <span class="text-[7px] text-white font-bold">DOCX</span>
                                </div>
                            </div>
                            <p class="text-center font-bold text-[8px] text-slate-400 uppercase tracking-wider">Homework</p>
                        </div>
                    </div>

                    <div class="absolute inset-0 bg-primary mix-blend-screen opacity-10 pointer-events-none"></div>

                    <div class="absolute top-8 -left-4 border-2 border-slate-900 bg-[#FFD700] px-3 py-1 font-bold text-slate-900 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] rotate-[-6deg] sketch-border text-[10px]">
                        Ask AI anything!
                    </div>
                    <div class="absolute bottom-12 -right-6 border-2 border-slate-900 bg-[#FF6B6B] px-3 py-1 font-bold text-white shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] rotate-[12deg] pixel-border text-[10px]">
                        Ready in seconds
                    </div>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section id="features" class="w-full bg-surface-container-low py-20 border-y-4 border-dashed border-outline-variant mt-12">
            <div class="max-w-7xl mx-auto px-4 md:px-8 flex flex-col gap-12">
                <div class="flex flex-col items-center text-center gap-4">
                    <h2 class="font-headline-lg text-headline-lg text-on-background">Everything a Teacher Needs</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">Two powerful tools built to save you hours every week.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-surface border-2 border-slate-900 p-8 shadow-[8px_8px_0px_0px_rgba(30,41,59,1)] sketch-border flex flex-col gap-4 group hover:-translate-y-1 transition-transform">
                        <div class="w-16 h-16 rounded-full border-2 border-slate-900 bg-blue-100 flex items-center justify-center text-blue-700 sketch-border mb-2 group-hover:rotate-12 transition-transform">
                            <span class="material-symbols-outlined text-[32px]">chat</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-background">AI Chat Assistant</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Ask anything — lesson plans, concept explanations, activity ideas, or just brainstorm. Your AI teaching partner is always online.</p>
                    </div>
                    <div class="bg-surface border-2 border-slate-900 p-8 shadow-[8px_8px_0px_0px_rgba(30,41,59,1)] sketch-border flex flex-col gap-4 group hover:-translate-y-1 transition-transform">
                        <div class="w-16 h-16 rounded-full border-2 border-slate-900 bg-yellow-100 flex items-center justify-center text-yellow-700 sketch-border mb-2 group-hover:rotate-12 transition-transform">
                            <span class="material-symbols-outlined text-[32px]">assignment</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-background">Homework Generator</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Upload your lesson PDF, describe what you need, and the AI generates a complete homework assignment — ready to download as PDF or Word.</p>
                    </div>
                    <div class="bg-surface border-2 border-slate-900 p-8 shadow-[8px_8px_0px_0px_rgba(30,41,59,1)] sketch-border flex flex-col gap-4 group hover:-translate-y-1 transition-transform">
                        <div class="w-16 h-16 rounded-full border-2 border-slate-900 bg-green-100 flex items-center justify-center text-green-700 sketch-border mb-2 group-hover:rotate-12 transition-transform">
                            <span class="material-symbols-outlined text-[32px]">memory</span>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-on-background">Cross-session Memory</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">The AI remembers context from your past conversations so you never have to repeat yourself. It gets smarter the more you use it.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works -->
        <section id="how-it-works" class="w-full max-w-7xl mx-auto px-4 md:px-8 py-20 flex flex-col gap-12 relative">
            <div class="flex flex-col items-center text-center gap-4">
                <h2 class="font-headline-lg text-headline-lg text-on-background">How It Works</h2>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">Three simple steps to go from lesson plan to ready homework.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                <svg class="hidden md:block absolute top-1/2 left-[25%] w-[16%] h-16 -translate-y-1/2 z-0 text-slate-900 pointer-events-none" preserveAspectRatio="none" viewBox="0 0 100 20">
                    <path d="M0 10 Q 50 -10 100 10" fill="none" stroke="currentColor" stroke-dasharray="4 4" stroke-width="2"/>
                    <polygon fill="currentColor" points="95,5 100,10 95,15"/>
                </svg>
                <svg class="hidden md:block absolute top-1/2 left-[58%] w-[16%] h-16 -translate-y-1/2 z-0 text-slate-900 pointer-events-none" preserveAspectRatio="none" viewBox="0 0 100 20">
                    <path d="M0 10 Q 50 30 100 10" fill="none" stroke="currentColor" stroke-dasharray="4 4" stroke-width="2"/>
                    <polygon fill="currentColor" points="95,5 100,10 95,15"/>
                </svg>

                <div class="bg-surface-container-lowest border-2 border-slate-900 p-8 shadow-[8px_8px_0px_0px_rgba(30,41,59,1)] hover:-translate-y-2 hover:translate-x-2 hover:shadow-[0px_0px_0px_0px_rgba(30,41,59,1)] transition-all duration-200 sketch-border flex flex-col gap-6 relative group z-10">
                    <div class="w-16 h-16 bg-blue-100 border-2 border-slate-900 flex items-center justify-center pixel-border text-blue-700">
                        <span class="material-symbols-outlined text-[32px]">upload_file</span>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h3 class="font-headline-md text-headline-md text-on-background">1. Upload Your Lesson</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Upload your lesson PDF and describe the homework you want — number of questions, type, difficulty level.</p>
                    </div>
                    <div class="absolute top-4 right-4 text-outline font-bold text-[12px] opacity-50 group-hover:opacity-100 group-hover:text-primary transition-colors">01</div>
                </div>

                <div class="bg-surface-container-low border-2 border-slate-900 p-8 shadow-[8px_8px_0px_0px_rgba(30,41,59,1)] hover:-translate-y-2 hover:translate-x-2 hover:shadow-[0px_0px_0px_0px_rgba(30,41,59,1)] transition-all duration-200 sketch-border flex flex-col gap-6 relative group md:-translate-y-4 z-10">
                    <div class="w-16 h-16 bg-yellow-100 border-2 border-slate-900 flex items-center justify-center pixel-border text-yellow-700">
                        <span class="material-symbols-outlined text-[32px]">smart_toy</span>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h3 class="font-headline-md text-headline-md text-on-background">2. AI Generates It</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Google Gemini reads your lesson, understands the content, and crafts a complete, well-structured homework assignment.</p>
                    </div>
                    <div class="absolute top-4 right-4 text-outline font-bold text-[12px] opacity-50 group-hover:opacity-100 group-hover:text-primary transition-colors">02</div>
                </div>

                <div class="bg-surface-container-lowest border-2 border-slate-900 p-8 shadow-[8px_8px_0px_0px_rgba(30,41,59,1)] hover:-translate-y-2 hover:translate-x-2 hover:shadow-[0px_0px_0px_0px_rgba(30,41,59,1)] transition-all duration-200 sketch-border flex flex-col gap-6 relative group z-10">
                    <div class="w-16 h-16 bg-green-100 border-2 border-slate-900 flex items-center justify-center pixel-border text-green-700">
                        <span class="material-symbols-outlined text-[32px]">download</span>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h3 class="font-headline-md text-headline-md text-on-background">3. Download & Done</h3>
                        <p class="font-body-md text-body-md text-on-surface-variant">Download your homework as a polished PDF or Word document. Print it or share it — it's ready to go.</p>
                    </div>
                    <div class="absolute top-4 right-4 text-outline font-bold text-[12px] opacity-50 group-hover:opacity-100 group-hover:text-primary transition-colors">03</div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section id="testimonials" class="w-full bg-slate-900 text-white py-20 border-y-4 border-slate-900 sketch-border -skew-y-1 my-12">
            <div class="max-w-7xl mx-auto px-4 md:px-8 flex flex-col gap-16 skew-y-1">
                <div class="flex flex-col items-center text-center gap-4">
                    <h2 class="font-headline-lg text-headline-lg text-white">Loved by Teachers</h2>
                    <p class="font-body-md text-body-md text-slate-300 max-w-2xl">Real teachers, real time saved.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                    <div class="relative bg-white text-slate-900 p-8 shadow-[8px_8px_0px_0px_#adc6ff] quote-bubble-border flex flex-col gap-6">
                        <p class="font-body-lg text-body-lg italic">"I used to spend 2 hours writing homework every Sunday. Now I upload my lesson notes and have it done in 2 minutes. FigCo is a lifesaver."</p>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-100 border-2 border-slate-900 pixel-border flex items-center justify-center">
                                <span class="material-symbols-outlined text-blue-700">person</span>
                            </div>
                            <div>
                                <h4 class="font-headline-md text-[18px] font-bold">Ms. Ratanak</h4>
                                <p class="font-bold text-[12px] text-slate-500 uppercase">High School Science Teacher</p>
                            </div>
                        </div>
                    </div>
                    <div class="relative bg-white text-slate-900 p-8 shadow-[8px_8px_0px_0px_#ffdad6] quote-bubble-border flex flex-col gap-6 md:translate-y-8">
                        <p class="font-body-lg text-body-lg italic">"The AI chat is like having a teaching partner available 24/7. I ask it for activity ideas, it gives me five options instantly. Incredible."</p>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-yellow-100 border-2 border-slate-900 pixel-border flex items-center justify-center">
                                <span class="material-symbols-outlined text-yellow-700">person</span>
                            </div>
                            <div>
                                <h4 class="font-headline-md text-[18px] font-bold">Mr. Sopheak</h4>
                                <p class="font-bold text-[12px] text-slate-500 uppercase">Primary School Teacher</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Final CTA -->
        <section class="w-full max-w-4xl mx-auto px-4 md:px-8 py-24 flex flex-col items-center text-center gap-8">
            <div class="w-24 h-24 bg-[#FFD700] border-4 border-slate-900 rounded-full flex items-center justify-center sketch-border animate-bounce mb-4 shadow-[8px_8px_0px_0px_rgba(30,41,59,1)]">
                <span class="material-symbols-outlined text-[48px] text-slate-900">school</span>
            </div>
            <h2 class="font-headline-xl text-headline-xl text-on-background">Ready to Teach Smarter?</h2>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl">
                Join teachers who are saving hours every week with AI-powered lesson planning and homework generation.
            </p>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="mt-4 border-4 border-slate-900 bg-primary text-on-primary px-10 py-5 text-xl font-bold shadow-[8px_8px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none transition-all duration-75 active:scale-95 sketch-border inline-flex items-center justify-center gap-3">
                    <span class="material-symbols-outlined">rocket_launch</span>
                    Get Started Free
                </a>
            @endif
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-blue-50 border-t-4 border-slate-900 mt-20 w-full pt-16 pb-8 px-8 flex flex-col gap-12 sketch-border relative overflow-hidden">
        <div class="max-w-7xl mx-auto w-full grid grid-cols-1 md:grid-cols-4 gap-8 relative z-10">
            <div class="flex flex-col gap-4">
                <span class="font-black text-2xl text-slate-900 italic" style="font-family: Epilogue, sans-serif;">FigCo</span>
                <p class="font-body-md text-body-md text-slate-600">AI-powered tools that help teachers plan better, teach smarter, and save more time.</p>
            </div>
            <div class="flex flex-col gap-4">
                <h4 class="font-bold uppercase tracking-widest text-slate-900 text-[12px]">Product</h4>
                <a class="text-slate-500 hover:text-blue-500 font-body-md transition-colors" href="#features">Features</a>
                <a class="text-slate-500 hover:text-blue-500 font-body-md transition-colors" href="#how-it-works">How It Works</a>
                <a class="text-slate-500 hover:text-blue-500 font-body-md transition-colors" href="{{ route('register') }}">Sign Up</a>
            </div>
            <div class="flex flex-col gap-4">
                <h4 class="font-bold uppercase tracking-widest text-slate-900 text-[12px]">Features</h4>
                <a class="text-slate-500 hover:text-blue-500 font-body-md transition-colors" href="{{ route('register') }}">AI Chat Assistant</a>
                <a class="text-slate-500 hover:text-blue-500 font-body-md transition-colors" href="{{ route('register') }}">Homework Generator</a>
                <a class="text-slate-500 hover:text-blue-500 font-body-md transition-colors" href="{{ route('register') }}">PDF & DOCX Export</a>
            </div>
            <div class="flex flex-col gap-4">
                <h4 class="font-bold uppercase tracking-widest text-slate-900 text-[12px]">Legal</h4>
                <a class="text-slate-500 hover:text-blue-500 font-body-md transition-colors" href="#">Privacy Policy</a>
                <a class="text-slate-500 hover:text-blue-500 font-body-md transition-colors" href="#">Terms of Service</a>
            </div>
        </div>
        <div class="max-w-7xl mx-auto w-full pt-8 border-t-2 border-dashed border-slate-300 flex flex-col md:flex-row justify-between items-center gap-4 relative z-10">
            <span class="font-bold uppercase tracking-widest text-slate-900 text-[12px]">© {{ date('Y') }} FigCo — Teaching Smarter with AI.</span>
            <div class="flex gap-6 font-bold uppercase tracking-widest text-[12px]">
                <a class="text-slate-500 hover:text-blue-500 underline transition-colors duration-200" href="#">GitHub</a>
                <a class="text-slate-500 hover:text-blue-500 underline transition-colors duration-200" href="#">Discord</a>
                <a class="text-slate-500 hover:text-blue-500 underline transition-colors duration-200" href="#">Twitter</a>
            </div>
        </div>
        <div class="absolute right-8 bottom-[-10px] opacity-20 pointer-events-none transform scale-150 text-slate-900 hidden md:block">
            <span class="material-symbols-outlined text-[100px]" style="font-variation-settings: 'FILL' 1;">school</span>
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
                function easeInOutCubic(t) { return t < 0.5 ? 4*t*t*t : 1 - Math.pow(-2*t+2,3)/2; }
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
