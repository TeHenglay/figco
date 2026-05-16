<x-app-layout>

    <!-- Header -->
    <header class="flex justify-between items-center mb-10">
        <div class="flex items-center gap-4">
            <h2 class="font-headline-xl text-headline-xl text-slate-900" style="font-family: Epilogue, sans-serif;">Projects</h2>
            <div class="hidden lg:flex items-center gap-2 bg-surface-container-high px-3 py-1 border-2 border-slate-900 font-technical-xs text-technical-xs text-slate-700" style="font-family: 'Space Grotesk', sans-serif;">
                <span class="w-2 h-2 bg-green-500 border border-slate-900 block"></span>
                {{ $projects->count() }} {{ Str::plural('Blueprint', $projects->count()) }}
            </div>
        </div>
        <a href="{{ route('projects.create') }}"
           class="border-2 border-slate-900 bg-primary text-on-primary px-5 py-3 font-technical-xs text-technical-xs font-bold shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all duration-75 sketch-border inline-flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">add</span>
            New Project
        </a>
    </header>

    @if (session('success'))
        <div class="mb-8 p-4 border-2 border-green-600 bg-green-50 text-green-800 font-technical-sm text-technical-sm flex items-center gap-3 shadow-[4px_4px_0px_0px_rgba(22,101,52,1)]">
            <span class="material-symbols-outlined text-green-600">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    @if ($projects->isEmpty())
        <!-- Empty state -->
        <div class="flex flex-col items-center justify-center py-24 border-4 border-dashed border-outline-variant sketch-border bg-surface-container-low">
            <div class="w-24 h-24 border-4 border-slate-900 bg-primary-fixed flex items-center justify-center sketch-border mb-6 shadow-[8px_8px_0px_0px_rgba(30,41,59,1)]">
                <span class="material-symbols-outlined text-[48px] text-on-primary-fixed">folder_open</span>
            </div>
            <h3 class="font-headline-md text-headline-md text-on-background mb-2" style="font-family: Epilogue, sans-serif;">No blueprints yet</h3>
            <p class="font-body-md text-body-md text-on-surface-variant mb-8 text-center max-w-sm">Create your first project, paste a Figma URL and watch the magic happen.</p>
            <a href="{{ route('projects.create') }}"
               class="border-2 border-slate-900 bg-primary text-on-primary px-8 py-4 font-technical-sm text-technical-sm font-bold shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none transition-all duration-75 sketch-border inline-flex items-center gap-2">
                <span class="material-symbols-outlined">add</span>
                Create First Project
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($projects as $project)
                <a href="{{ route('projects.show', $project) }}"
                   class="bg-white p-5 wobbly-border pixel-shadow hover:-translate-y-1 hover:pixel-shadow-lg transition-all group cursor-pointer block">

                    <!-- Blueprint preview area -->
                    <div class="aspect-video w-full border-2 border-slate-900 mb-4 bg-slate-100 relative overflow-hidden flex items-center justify-center">
                        <div class="absolute inset-0 opacity-20" style="background-image: linear-gradient(#0058be 1px, transparent 1px), linear-gradient(90deg, #0058be 1px, transparent 1px); background-size: 16px 16px;"></div>
                        <span class="material-symbols-outlined text-4xl text-slate-400 relative z-10 group-hover:text-primary transition-colors">view_quilt</span>
                        <div class="absolute top-2 right-2 bg-white border-2 border-slate-900 px-2 py-0.5 font-technical-xs text-technical-xs" style="font-family: 'Space Grotesk', sans-serif;">
                            {{ $project->components_count }} {{ Str::plural('comp', $project->components_count) }}
                        </div>
                    </div>

                    <h3 class="font-headline-md text-on-background truncate mb-1" style="font-family: Epilogue, sans-serif; font-size: 18px; font-weight: 600;">
                        {{ $project->name }}
                    </h3>

                    @if ($project->figma_file_key)
                        <p class="font-technical-xs text-technical-xs text-slate-400 truncate mb-3" style="font-family: 'Space Grotesk', sans-serif;">
                            {{ $project->figma_file_key }}
                        </p>
                    @else
                        <p class="font-body-md text-body-md text-slate-400 text-sm mb-3">No Figma key</p>
                    @endif

                    <div class="flex items-center justify-between">
                        <div class="flex gap-2">
                            <span class="px-2 py-1 bg-surface-variant border border-slate-900 font-technical-xs text-technical-xs" style="font-family: 'Space Grotesk', sans-serif;">Blueprint</span>
                            <span class="px-2 py-1 bg-blue-100 border border-slate-900 font-technical-xs text-technical-xs text-blue-800" style="font-family: 'Space Grotesk', sans-serif;">Active</span>
                        </div>
                        <span class="font-technical-xs text-technical-xs text-slate-400" style="font-family: 'Space Grotesk', sans-serif;">{{ $project->updated_at->diffForHumans() }}</span>
                    </div>
                </a>
            @endforeach

            <!-- New project card -->
            <a href="{{ route('projects.create') }}"
               class="border-4 border-dashed border-outline-variant bg-surface-container-low hover:bg-surface-container hover:border-primary transition-all group flex flex-col items-center justify-center gap-3 p-8 min-h-[200px] sketch-border">
                <div class="w-12 h-12 border-2 border-slate-400 group-hover:border-primary flex items-center justify-center pixel-border transition-colors">
                    <span class="material-symbols-outlined text-slate-400 group-hover:text-primary transition-colors">add</span>
                </div>
                <span class="font-technical-sm text-technical-sm text-slate-500 group-hover:text-primary transition-colors" style="font-family: 'Space Grotesk', sans-serif;">New Project</span>
            </a>
        </div>
    @endif

</x-app-layout>
