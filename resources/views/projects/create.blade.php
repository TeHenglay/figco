<x-app-layout>

    <!-- Header -->
    <header class="flex items-center gap-4 mb-10">
        <a href="{{ route('projects.index') }}"
           class="w-10 h-10 border-2 border-slate-900 bg-white flex items-center justify-center pixel-shadow btn-hover transition-transform flex-shrink-0">
            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
        </a>
        <div>
            <h2 class="font-headline-xl text-headline-xl text-slate-900" style="font-family: Epilogue, sans-serif;">New Project</h2>
            <p class="font-technical-sm text-technical-sm text-slate-500 uppercase tracking-wider mt-1" style="font-family: 'Space Grotesk', sans-serif;">Blueprint Canvas Setup</p>
        </div>
    </header>

    <div class="max-w-2xl">
        <div class="bg-white border-2 border-slate-900 shadow-[8px_8px_0px_0px_rgba(30,41,59,1)] sketch-border overflow-hidden">
            <!-- Card accent bar -->
            <div class="h-2 bg-primary"></div>

            <div class="p-8">
                <form method="POST" action="{{ route('projects.store') }}" class="flex flex-col gap-6" x-data="{ loading: false }" @submit="loading = true">
                    @csrf

                    <!-- Project Name -->
                    <div class="flex flex-col gap-2">
                        <label for="name" class="font-technical-sm text-technical-sm text-slate-900 uppercase tracking-wider font-bold" style="font-family: 'Space Grotesk', sans-serif;">
                            Project Name <span class="text-error">*</span>
                        </label>
                        <input
                            id="name" name="name" type="text"
                            value="{{ old('name') }}"
                            required autofocus
                            placeholder="My Design System"
                            class="w-full px-4 py-3 border-2 border-slate-900 bg-white font-body-md focus:outline-none focus:border-primary focus:shadow-[4px_4px_0px_0px_#005ac2] transition-shadow placeholder-slate-300"
                            style="font-family: Inter, sans-serif; border-radius: 0;"
                        />
                        @error('name')
                            <p class="font-technical-xs text-technical-xs text-error flex items-center gap-1" style="font-family: 'Space Grotesk', sans-serif;">
                                <span class="material-symbols-outlined text-[14px]">error</span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Figma File Key -->
                    <div class="flex flex-col gap-2">
                        <label for="figma_file_key" class="font-technical-sm text-technical-sm text-slate-900 uppercase tracking-wider font-bold" style="font-family: 'Space Grotesk', sans-serif;">
                            Figma File Key <span class="text-slate-400 font-normal normal-case tracking-normal">(optional)</span>
                        </label>
                        <input
                            id="figma_file_key" name="figma_file_key" type="text"
                            value="{{ old('figma_file_key') }}"
                            placeholder="e.g. aBcDeFgHiJkL"
                            class="w-full px-4 py-3 border-2 border-slate-900 bg-white font-technical-sm focus:outline-none focus:border-primary focus:shadow-[4px_4px_0px_0px_#005ac2] transition-shadow placeholder-slate-300"
                            style="font-family: 'Space Grotesk', sans-serif; border-radius: 0;"
                        />
                        <div class="flex items-start gap-2 p-3 bg-surface-container-low border-2 border-outline-variant">
                            <span class="material-symbols-outlined text-[16px] text-outline mt-0.5 flex-shrink-0">info</span>
                            <p class="font-technical-xs text-technical-xs text-on-surface-variant" style="font-family: 'Space Grotesk', sans-serif;">
                                Found in the Figma URL: figma.com/file/<strong class="text-primary">FILE_KEY</strong>/...
                            </p>
                        </div>
                        @error('figma_file_key')
                            <p class="font-technical-xs text-technical-xs text-error flex items-center gap-1" style="font-family: 'Space Grotesk', sans-serif;">
                                <span class="material-symbols-outlined text-[14px]">error</span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-4 pt-2 border-t-2 border-dashed border-outline-variant mt-2">
                        <button type="submit"
                                :disabled="loading"
                                :class="loading ? 'opacity-75 cursor-not-allowed translate-x-[2px] translate-y-[2px] shadow-none' : 'shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none'"
                                class="border-2 border-slate-900 bg-primary text-on-primary px-8 py-3 font-technical-sm text-technical-sm font-bold transition-all duration-75 sketch-border inline-flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px] transition-all" :class="loading ? 'animate-spin' : ''" x-text="loading ? 'progress_activity' : 'draw'">draw</span>
                            <span x-text="loading ? 'Creating...' : 'Create Project'">Create Project</span>
                        </button>
                        <a href="{{ route('projects.index') }}"
                           class="font-technical-sm text-technical-sm text-slate-600 hover:text-slate-900 transition-colors" style="font-family: 'Space Grotesk', sans-serif;">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Decorative sticker -->
        <div class="mt-4 flex justify-end">
            <div class="border-2 border-slate-900 bg-[#FFD700] px-3 py-1 font-technical-xs text-technical-xs text-slate-900 shadow-[3px_3px_0px_0px_rgba(30,41,59,1)] rotate-[-2deg] sketch-border" style="font-family: 'Space Grotesk', sans-serif;">
                Step 1 of 3: Name your blueprint
            </div>
        </div>
    </div>

</x-app-layout>
