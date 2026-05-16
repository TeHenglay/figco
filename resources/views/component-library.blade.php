<x-app-layout>

    <!-- Header -->
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="font-headline-xl text-headline-xl text-slate-900" style="font-family: Epilogue, sans-serif;">Component Library</h2>
            <p class="font-technical-sm text-technical-sm text-slate-500 mt-1">All generated components across your projects</p>
        </div>
        <a href="{{ route('projects.index') }}"
           class="border-2 border-slate-900 bg-primary text-on-primary px-5 py-3 font-technical-xs text-technical-xs uppercase tracking-wider font-bold pixel-shadow btn-hover transition-all inline-flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">add</span>
            New Component
        </a>
    </header>

    @if($components->isEmpty())
        <!-- Empty State -->
        <div class="flex flex-col items-center justify-center py-24 border-4 border-dashed border-slate-300 sketch-border bg-surface-container-low">
            <div class="w-20 h-20 border-4 border-slate-900 bg-primary-fixed flex items-center justify-center sketch-border mb-6 shadow-[6px_6px_0px_0px_rgba(30,41,59,1)]">
                <span class="material-symbols-outlined text-[40px] text-on-primary-fixed">grid_view</span>
            </div>
            <h3 class="font-headline-md text-headline-md text-slate-900 mb-2" style="font-family: Epilogue, sans-serif;">No components yet</h3>
            <p class="font-body-md text-body-md text-slate-500 mb-8 text-center max-w-sm">Create a project and generate your first component from Figma.</p>
            <a href="{{ route('projects.index') }}"
               class="border-2 border-slate-900 bg-primary text-on-primary px-8 py-4 font-technical-sm text-technical-sm font-bold shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none transition-all duration-75 sketch-border inline-flex items-center gap-2">
                <span class="material-symbols-outlined">folder_open</span>
                Go to Projects
            </a>
        </div>
    @else
        <!-- Stats Bar -->
        <div class="flex items-center gap-6 mb-8 px-4 py-3 bg-surface-container-low border-2 border-slate-900">
            <div class="flex items-center gap-2 font-technical-xs text-technical-xs text-slate-700">
                <span class="w-2 h-2 bg-blue-500 border border-slate-900 block"></span>
                <span>{{ $components->total() }} total components</span>
            </div>
            <div class="flex items-center gap-2 font-technical-xs text-technical-xs text-slate-700">
                <span class="w-2 h-2 bg-green-500 border border-slate-900 block"></span>
                <span>{{ $components->where('status', 'done')->count() }} done</span>
            </div>
            <div class="flex items-center gap-2 font-technical-xs text-technical-xs text-slate-700">
                <span class="w-2 h-2 bg-yellow-400 border border-slate-900 block"></span>
                <span>{{ $components->where('status', 'processing')->count() }} processing</span>
            </div>
        </div>

        <!-- Component Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($components as $component)
                <a href="{{ route('components.show', $component) }}"
                   class="bg-white border-2 border-slate-900 pixel-shadow hover:-translate-y-1 hover:pixel-shadow-lg transition-all group block">

                    <!-- Preview Area -->
                    <div class="aspect-video w-full border-b-2 border-slate-900 bg-slate-100 relative overflow-hidden flex items-center justify-center">
                        <div class="absolute inset-0 opacity-10" style="background-image: linear-gradient(#0058be 1px, transparent 1px), linear-gradient(90deg, #0058be 1px, transparent 1px); background-size: 12px 12px;"></div>
                        <span class="material-symbols-outlined text-4xl text-slate-300 relative z-10">code_blocks</span>

                        <!-- Framework badge -->
                        <div class="absolute top-2 left-2 px-2 py-1 border-2 border-slate-900 font-technical-xs text-technical-xs uppercase
                            {{ $component->framework === 'react' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                            {{ $component->framework }}
                        </div>

                        <!-- Status badge -->
                        <div class="absolute top-2 right-2 flex items-center gap-1 px-2 py-1 border-2 border-slate-900 font-technical-xs text-technical-xs
                            @if($component->status === 'done') bg-green-500 text-white
                            @elseif($component->status === 'processing') bg-yellow-400 text-slate-900
                            @elseif($component->status === 'failed') bg-red-500 text-white
                            @else bg-slate-200 text-slate-700 @endif">
                            <span class="material-symbols-outlined text-[12px]">
                                @if($component->status === 'done') check_circle
                                @elseif($component->status === 'processing') sync
                                @elseif($component->status === 'failed') error
                                @else schedule @endif
                            </span>
                            {{ ucfirst($component->status) }}
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="p-4">
                        <h3 class="font-headline-md text-headline-md text-slate-900 truncate mb-1" style="font-family: Epilogue, sans-serif; font-size: 16px;">{{ $component->name }}</h3>
                        <p class="font-technical-xs text-technical-xs text-slate-500 truncate">
                            <span class="material-symbols-outlined text-[12px] align-middle">folder_open</span>
                            {{ $component->project->name }}
                        </p>
                        <p class="font-technical-xs text-technical-xs text-slate-400 mt-2">{{ $component->created_at->diffForHumans() }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($components->hasPages())
            <div class="mt-10 flex justify-center">
                {{ $components->links() }}
            </div>
        @endif
    @endif

</x-app-layout>
