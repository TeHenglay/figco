<x-app-layout>

    <!-- Top Header Bar -->
    <header class="flex justify-between items-center mb-12">
        <div class="flex items-center gap-4">
            <h2 class="font-headline-xl text-headline-xl text-slate-900" style="font-family: Epilogue, sans-serif;">Dashboard</h2>
            <div class="hidden lg:flex items-center gap-2 bg-surface-container-high px-3 py-1 border-2 border-slate-900 font-technical-xs text-technical-xs text-slate-700" style="font-family: 'Space Grotesk', sans-serif;">
                <span class="w-2 h-2 bg-green-500 border border-slate-900 block"></span>
                System Online
            </div>
        </div>
        <div class="flex items-center gap-4">
            <!-- Search -->
            <div class="relative hidden sm:block">
                <input
                    class="w-64 px-4 py-2 bg-white border-2 border-slate-900 font-technical-xs text-technical-xs focus:outline-none focus:border-blue-600 focus:shadow-[4px_4px_0px_0px_#005ac2] transition-shadow placeholder-slate-400"
                    style="font-family: 'Space Grotesk', sans-serif;"
                    placeholder="Search blueprints..."
                    type="text"
                />
                <span class="material-symbols-outlined absolute right-3 top-2 text-slate-500 text-[20px]">search</span>
            </div>
            <!-- Action buttons -->
            <div class="flex gap-2">
                <button class="w-10 h-10 flex items-center justify-center bg-white border-2 border-slate-900 pixel-shadow btn-hover transition-transform">
                    <span class="material-symbols-outlined text-[20px]">notifications</span>
                </button>
                <button class="w-10 h-10 flex items-center justify-center bg-white border-2 border-slate-900 pixel-shadow btn-hover transition-transform">
                    <span class="material-symbols-outlined text-[20px]">help</span>
                </button>
            </div>
            <!-- Avatar -->
            <div class="w-10 h-10 border-2 border-slate-900 bg-primary-fixed flex items-center justify-center pixel-border flex-shrink-0">
                <span class="material-symbols-outlined text-[20px] text-on-primary-fixed">person</span>
            </div>
        </div>
    </header>

    <!-- Stats Bento Grid -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">

        <!-- Stat Card 1: Total Generations -->
        <div class="bg-surface-container-low p-6 wobbly-border pixel-shadow-lg relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-16 h-16 bg-blue-100 border-l-2 border-b-2 border-slate-900 -mr-8 -mt-8 rotate-45 flex items-end justify-center pb-2">
                <span class="material-symbols-outlined text-blue-600 rotate-[-45deg] text-sm">trending_up</span>
            </div>
            <h3 class="font-technical-sm text-technical-sm text-slate-600 uppercase mb-2">Total Generations</h3>
            <p class="font-headline-lg text-headline-lg text-slate-900">{{ auth()->user()->projects()->count() > 0 ? auth()->user()->projects()->count() * 47 : '1,024' }}</p>
            <div class="mt-4 flex items-center gap-2 font-technical-xs text-technical-xs text-blue-600">
                <span class="px-2 py-1 bg-white border-2 border-slate-900">+12% this week</span>
            </div>
        </div>

        <!-- Stat Card 2: Active Projects -->
        <div class="bg-surface p-6 border-2 border-slate-900 pixel-shadow relative">
            <h3 class="font-technical-sm text-technical-sm text-slate-600 uppercase mb-2">Active Projects</h3>
            <p class="font-headline-lg text-headline-lg text-slate-900">{{ auth()->user()->projects()->count() }}</p>
            <div class="mt-4 w-full bg-slate-200 border-2 border-slate-900 h-4">
                <div class="bg-blue-500 h-full border-r-2 border-slate-900 transition-all" style="width: {{ min(100, auth()->user()->projects()->count() * 12.5) }}%"></div>
            </div>
            <p class="mt-2 font-technical-xs text-technical-xs text-right text-slate-500">{{ min(100, auth()->user()->projects()->count() * 12.5) }}% Capacity</p>
        </div>

        <!-- CTA Card -->
        <div class="bg-blue-600 text-white p-6 border-2 border-slate-900 pixel-shadow-lg flex flex-col justify-center items-center text-center">
            <h3 class="font-headline-md text-headline-md mb-2" style="font-family: Epilogue, sans-serif;">Start Fresh</h3>
            <p class="font-body-md text-body-md mb-4 opacity-90 text-sm">Spin up a new blueprint canvas.</p>
            <a href="{{ route('projects.create') }}"
               class="px-6 py-2 bg-yellow-300 text-slate-900 border-2 border-slate-900 pixel-shadow btn-hover transition-transform font-technical-xs text-technical-xs uppercase tracking-wider font-bold w-full text-center block">
                New Generation
            </a>
        </div>

    </section>

    <!-- Recent Projects Section -->
    <section>
        <div class="flex justify-between items-end mb-6 border-b-4 border-slate-900 pb-2">
            <h2 class="font-headline-lg text-headline-lg text-slate-900" style="font-family: Epilogue, sans-serif;">Recent Projects</h2>
            <a href="{{ route('projects.index') }}" class="font-technical-sm text-technical-sm text-blue-600 hover:underline decoration-2 underline-offset-4">View All</a>
        </div>

        @if(auth()->user()->projects()->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach(auth()->user()->projects()->latest()->take(8)->get() as $project)
                    <a href="{{ route('projects.show', $project) }}"
                       class="bg-white p-4 wobbly-border pixel-shadow hover:-translate-y-1 hover:pixel-shadow-lg transition-all group cursor-pointer block">
                        <div class="aspect-video w-full border-2 border-slate-900 mb-4 bg-slate-100 relative overflow-hidden flex items-center justify-center">
                            <!-- Blueprint grid preview -->
                            <div class="absolute inset-0 opacity-20" style="background-image: linear-gradient(#0058be 1px, transparent 1px), linear-gradient(90deg, #0058be 1px, transparent 1px); background-size: 16px 16px;"></div>
                            <span class="material-symbols-outlined text-4xl text-slate-400 relative z-10">view_quilt</span>
                            <div class="absolute top-2 right-2 bg-white border-2 border-slate-900 px-2 py-1 font-technical-xs text-technical-xs">
                                v1.0
                            </div>
                        </div>
                        <h3 class="font-headline-md text-headline-md text-slate-900 truncate" style="font-family: Epilogue, sans-serif; font-size: 18px;">{{ $project->name }}</h3>
                        <p class="font-body-md text-body-md text-slate-500 text-sm mt-1 mb-3 truncate">{{ $project->description ?? 'No description' }}</p>
                        <div class="flex gap-2 flex-wrap">
                            <span class="px-2 py-1 bg-surface-variant border border-slate-900 font-technical-xs text-technical-xs">Blueprint</span>
                            <span class="px-2 py-1 bg-blue-100 border border-slate-900 font-technical-xs text-technical-xs text-blue-800">Active</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <!-- Empty state -->
            <div class="flex flex-col items-center justify-center py-20 border-4 border-dashed border-outline-variant sketch-border bg-surface-container-low">
                <div class="w-20 h-20 border-4 border-slate-900 bg-primary-fixed flex items-center justify-center sketch-border mb-6 shadow-[6px_6px_0px_0px_rgba(30,41,59,1)]">
                    <span class="material-symbols-outlined text-[40px] text-on-primary-fixed">draw</span>
                </div>
                <h3 class="font-headline-md text-headline-md text-on-background mb-2" style="font-family: Epilogue, sans-serif;">No blueprints yet</h3>
                <p class="font-body-md text-body-md text-on-surface-variant mb-8 text-center max-w-sm">Start by creating your first project. Paste a Figma URL and watch the magic happen.</p>
                <a href="{{ route('projects.create') }}"
                   class="border-2 border-slate-900 bg-primary text-on-primary px-8 py-4 font-technical-sm text-technical-sm font-bold shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none transition-all duration-75 sketch-border inline-flex items-center gap-2">
                    <span class="material-symbols-outlined">add</span>
                    Create First Project
                </a>
            </div>
        @endif
    </section>

</x-app-layout>
