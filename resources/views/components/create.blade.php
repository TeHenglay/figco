<x-app-layout>

    <!-- Header -->
    <header class="flex items-center gap-4 mb-10">
        <a href="{{ route('projects.show', $project) }}"
           class="w-10 h-10 border-2 border-slate-900 bg-white flex items-center justify-center pixel-shadow btn-hover transition-transform flex-shrink-0">
            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
        </a>
        <div>
            <h2 class="font-headline-xl text-headline-xl text-slate-900" style="font-family: Epilogue, sans-serif;">Add Component</h2>
            <p class="font-technical-sm text-technical-sm text-slate-500 mt-1" style="font-family: 'Space Grotesk', sans-serif;">
                <span class="material-symbols-outlined text-[14px] align-middle">folder_open</span>
                {{ $project->name }}
            </p>
        </div>
    </header>

    <div class="max-w-2xl">

        @if (!auth()->user()->figma_access_token)
            <div class="mb-6 p-4 border-2 border-yellow-600 bg-yellow-50 shadow-[4px_4px_0px_0px_rgba(161,98,7,1)] flex gap-3">
                <span class="material-symbols-outlined text-yellow-700 flex-shrink-0">warning</span>
                <div class="font-technical-sm text-technical-sm text-yellow-800" style="font-family: 'Space Grotesk', sans-serif;">
                    No Figma access token set. The component will be queued but not sent for generation until you
                    <a href="{{ route('profile.edit') }}" class="underline font-bold hover:text-yellow-900">add your Figma token</a>.
                </div>
            </div>
        @endif

        <div class="bg-white border-2 border-slate-900 shadow-[8px_8px_0px_0px_rgba(30,41,59,1)] sketch-border overflow-hidden">
            <div class="h-2 bg-primary-container"></div>
            <div class="p-8">
                <form method="POST" action="{{ route('components.store', $project) }}" class="flex flex-col gap-6" x-data="{ loading: false }" @submit="loading = true">
                    @csrf

                    <!-- Component Name -->
                    <div class="flex flex-col gap-2">
                        <label for="name" class="font-technical-sm text-technical-sm text-slate-900 uppercase tracking-wider font-bold" style="font-family: 'Space Grotesk', sans-serif;">
                            Component Name <span class="text-error">*</span>
                        </label>
                        <input
                            id="name" name="name" type="text"
                            value="{{ old('name') }}"
                            required autofocus
                            placeholder="Button Primary"
                            class="w-full px-4 py-3 border-2 border-slate-900 bg-white font-body-md focus:outline-none focus:border-primary focus:shadow-[4px_4px_0px_0px_#005ac2] transition-shadow placeholder-slate-300"
                            style="font-family: Inter, sans-serif; border-radius: 0;"
                        />
                        @error('name')
                            <p class="font-technical-xs text-technical-xs text-error flex items-center gap-1" style="font-family: 'Space Grotesk', sans-serif;">
                                <span class="material-symbols-outlined text-[14px]">error</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Figma Node URL -->
                    <div class="flex flex-col gap-2">
                        <label for="figma_url" class="font-technical-sm text-technical-sm text-slate-900 uppercase tracking-wider font-bold" style="font-family: 'Space Grotesk', sans-serif;">
                            Figma Node URL <span class="text-error">*</span>
                        </label>
                        <input
                            id="figma_url" name="figma_url" type="url"
                            value="{{ old('figma_url') }}"
                            required
                            placeholder="https://www.figma.com/file/abc123/Design?node-id=1%3A2"
                            class="w-full px-4 py-3 border-2 border-slate-900 bg-white font-technical-sm focus:outline-none focus:border-primary focus:shadow-[4px_4px_0px_0px_#005ac2] transition-shadow placeholder-slate-300"
                            style="font-family: 'Space Grotesk', sans-serif; border-radius: 0; font-size: 13px;"
                        />
                        <div class="flex items-start gap-2 p-3 bg-surface-container-low border-2 border-outline-variant">
                            <span class="material-symbols-outlined text-[16px] text-outline mt-0.5 flex-shrink-0">info</span>
                            <p class="font-technical-xs text-technical-xs text-on-surface-variant" style="font-family: 'Space Grotesk', sans-serif;">
                                Right-click a frame or component in Figma → <strong>Copy link to selection</strong>
                            </p>
                        </div>
                        @error('figma_url')
                            <p class="font-technical-xs text-technical-xs text-error flex items-center gap-1" style="font-family: 'Space Grotesk', sans-serif;">
                                <span class="material-symbols-outlined text-[14px]">error</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Framework -->
                    <div class="flex flex-col gap-2">
                        <label class="font-technical-sm text-technical-sm text-slate-900 uppercase tracking-wider font-bold" style="font-family: 'Space Grotesk', sans-serif;">
                            Framework <span class="text-error">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="framework" value="react" class="sr-only peer" {{ old('framework', 'react') === 'react' ? 'checked' : '' }}>
                                <div class="border-2 border-slate-900 p-4 flex flex-col items-center gap-2 peer-checked:bg-primary peer-checked:text-white peer-checked:shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] hover:bg-surface-container transition-all pixel-border">
                                    <span class="material-symbols-outlined text-[28px]">code</span>
                                    <span class="font-technical-sm text-technical-sm font-bold" style="font-family: 'Space Grotesk', sans-serif;">React</span>
                                    <span class="font-technical-xs text-technical-xs opacity-70" style="font-family: 'Space Grotesk', sans-serif;">.jsx / .tsx</span>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="framework" value="vue" class="sr-only peer" {{ old('framework') === 'vue' ? 'checked' : '' }}>
                                <div class="border-2 border-slate-900 p-4 flex flex-col items-center gap-2 peer-checked:bg-primary peer-checked:text-white peer-checked:shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] hover:bg-surface-container transition-all pixel-border">
                                    <span class="material-symbols-outlined text-[28px]">hub</span>
                                    <span class="font-technical-sm text-technical-sm font-bold" style="font-family: 'Space Grotesk', sans-serif;">Vue</span>
                                    <span class="font-technical-xs text-technical-xs opacity-70" style="font-family: 'Space Grotesk', sans-serif;">.vue SFC</span>
                                </div>
                            </label>
                        </div>
                        @error('framework')
                            <p class="font-technical-xs text-technical-xs text-error flex items-center gap-1" style="font-family: 'Space Grotesk', sans-serif;">
                                <span class="material-symbols-outlined text-[14px]">error</span> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-4 pt-2 border-t-2 border-dashed border-outline-variant mt-2">
                        <button type="submit"
                                :disabled="loading"
                                :class="loading ? 'opacity-75 cursor-not-allowed translate-x-[2px] translate-y-[2px] shadow-none' : 'shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none'"
                                class="border-2 border-slate-900 bg-primary text-on-primary px-8 py-3 font-technical-sm text-technical-sm font-bold transition-all duration-75 sketch-border inline-flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]" :class="loading ? 'animate-spin' : ''" x-text="loading ? 'progress_activity' : 'rocket_launch'">rocket_launch</span>
                            <span x-text="loading ? 'Generating...' : 'Generate Component'">Generate Component</span>
                        </button>
                        <a href="{{ route('projects.show', $project) }}"
                           class="font-technical-sm text-technical-sm text-slate-600 hover:text-slate-900 transition-colors" style="font-family: 'Space Grotesk', sans-serif;">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
