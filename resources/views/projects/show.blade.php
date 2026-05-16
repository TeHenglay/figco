<x-app-layout>

    <!-- Header -->
    <header class="flex justify-between items-start mb-10 gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('projects.index') }}"
               class="w-10 h-10 border-2 border-slate-900 bg-white flex items-center justify-center pixel-shadow btn-hover transition-transform flex-shrink-0">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            </a>
            <div>
                <h2 class="font-headline-xl text-headline-xl text-slate-900" style="font-family: Epilogue, sans-serif;">{{ $project->name }}</h2>
                @if ($project->figma_file_key)
                    <p class="font-technical-xs text-technical-xs text-slate-400 mt-1" style="font-family: 'Space Grotesk', sans-serif;">
                        <span class="material-symbols-outlined text-[12px] align-middle">link</span>
                        {{ $project->figma_file_key }}
                    </p>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-3 flex-shrink-0">
            <a href="{{ route('components.create', $project) }}"
               class="border-2 border-slate-900 bg-primary text-on-primary px-5 py-3 font-technical-xs text-technical-xs font-bold shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all duration-75 sketch-border inline-flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Add Component
            </a>
            <form method="POST" action="{{ route('projects.destroy', $project) }}"
                  onsubmit="return confirm('Delete this project and all its components?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="border-2 border-error bg-white text-error px-4 py-3 font-technical-xs text-technical-xs font-bold shadow-[4px_4px_0px_0px_rgba(186,26,26,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all duration-75 sketch-border inline-flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">delete</span>
                    Delete
                </button>
            </form>
        </div>
    </header>

    @if (session('success'))
        <div class="mb-8 p-4 border-2 border-green-600 bg-green-50 text-green-800 font-technical-sm text-technical-sm flex items-center gap-3 shadow-[4px_4px_0px_0px_rgba(22,101,52,1)]" style="font-family: 'Space Grotesk', sans-serif;">
            <span class="material-symbols-outlined text-green-600">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    @if ($components->isEmpty())
        <!-- Empty state -->
        <div class="flex flex-col items-center justify-center py-24 border-4 border-dashed border-outline-variant sketch-border bg-surface-container-low">
            <div class="w-24 h-24 border-4 border-slate-900 bg-secondary-container flex items-center justify-center sketch-border mb-6 shadow-[8px_8px_0px_0px_rgba(30,41,59,1)]">
                <span class="material-symbols-outlined text-[48px] text-on-secondary-container">widgets</span>
            </div>
            <h3 class="font-headline-md text-headline-md text-on-background mb-2" style="font-family: Epilogue, sans-serif;">No components yet</h3>
            <p class="font-body-md text-body-md text-on-surface-variant mb-8 text-center max-w-sm">Add a Figma component URL to generate production-ready code.</p>
            <a href="{{ route('components.create', $project) }}"
               class="border-2 border-slate-900 bg-primary text-on-primary px-8 py-4 font-technical-sm text-technical-sm font-bold shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none transition-all duration-75 sketch-border inline-flex items-center gap-2">
                <span class="material-symbols-outlined">add</span>
                Add First Component
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($components as $component)
                <a href="{{ route('components.show', $component) }}"
                   class="bg-white p-5 wobbly-border pixel-shadow hover:-translate-y-1 hover:pixel-shadow-lg transition-all group cursor-pointer block">

                    @if ($component->thumbnail_url)
                        <div class="mb-4 border-2 border-slate-900 overflow-hidden h-32 bg-slate-100">
                            <img src="{{ $component->thumbnail_url }}" alt="{{ $component->name }}"
                                 class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all" />
                        </div>
                    @else
                        <div class="mb-4 border-2 border-slate-900 h-32 bg-slate-100 flex items-center justify-center relative overflow-hidden">
                            <div class="absolute inset-0 opacity-10" style="background-image: linear-gradient(#0058be 1px, transparent 1px), linear-gradient(90deg, #0058be 1px, transparent 1px); background-size: 12px 12px;"></div>
                            <span class="material-symbols-outlined text-4xl text-slate-300 relative z-10">code_blocks</span>
                        </div>
                    @endif

                    <div class="flex items-start justify-between gap-2 mb-2">
                        <h3 class="font-headline-md text-on-background truncate" style="font-family: Epilogue, sans-serif; font-size: 18px; font-weight: 600;">
                            {{ $component->name }}
                        </h3>
                        @php
                            $statusMap = [
                                'pending'    => ['bg-yellow-100 border-yellow-600 text-yellow-800', 'schedule'],
                                'processing' => ['bg-blue-100 border-blue-600 text-blue-800', 'sync'],
                                'done'       => ['bg-green-100 border-green-600 text-green-800', 'check_circle'],
                                'error'      => ['bg-red-100 border-red-600 text-red-800', 'error'],
                            ];
                            [$statusClass, $statusIcon] = $statusMap[$component->status] ?? ['bg-slate-100 border-slate-400 text-slate-700', 'help'];
                        @endphp
                        <span class="inline-flex items-center gap-1 px-2 py-1 border {{ $statusClass }} font-technical-xs text-technical-xs whitespace-nowrap flex-shrink-0" style="font-family: 'Space Grotesk', sans-serif;">
                            <span class="material-symbols-outlined text-[12px] {{ $component->status === 'processing' ? 'animate-spin' : '' }}">{{ $statusIcon }}</span>
                            {{ ucfirst($component->status) }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between mt-3">
                        <span class="px-2 py-1 bg-surface-variant border border-slate-900 font-technical-xs text-technical-xs uppercase" style="font-family: 'Space Grotesk', sans-serif;">{{ $component->framework }}</span>
                        <span class="font-technical-xs text-technical-xs text-slate-400" style="font-family: 'Space Grotesk', sans-serif;">{{ $component->updated_at->diffForHumans() }}</span>
                    </div>
                </a>
            @endforeach

            <!-- Add component card -->
            <a href="{{ route('components.create', $project) }}"
               class="border-4 border-dashed border-outline-variant bg-surface-container-low hover:bg-surface-container hover:border-primary transition-all group flex flex-col items-center justify-center gap-3 p-8 min-h-[200px] sketch-border">
                <div class="w-12 h-12 border-2 border-slate-400 group-hover:border-primary flex items-center justify-center pixel-border transition-colors">
                    <span class="material-symbols-outlined text-slate-400 group-hover:text-primary transition-colors">add</span>
                </div>
                <span class="font-technical-sm text-technical-sm text-slate-500 group-hover:text-primary transition-colors" style="font-family: 'Space Grotesk', sans-serif;">Add Component</span>
            </a>
        </div>
    @endif

</x-app-layout>
