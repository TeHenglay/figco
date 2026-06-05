<x-app-layout>

    <header class="flex items-center gap-4 mb-8">
        <a href="{{ route('homework.index') }}" class="w-9 h-9 border-2 border-slate-900 flex items-center justify-center hover:bg-surface-container transition-colors">
            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
        </a>
        <div class="flex-1 min-w-0">
            <h2 class="font-headline-xl text-headline-xl text-slate-900 truncate" style="font-family: Epilogue, sans-serif;">{{ $homework->original_filename }}</h2>
            <p class="font-technical-xs text-technical-xs text-slate-400 mt-1">Generated {{ $homework->created_at->diffForHumans() }}</p>
        </div>
        <span class="px-3 py-1.5 border-2 border-slate-900 font-technical-xs text-technical-xs uppercase tracking-wider font-bold
            {{ $homework->status === 'completed' ? 'bg-green-100 text-green-800 border-green-600' : ($homework->status === 'processing' ? 'bg-yellow-100 text-yellow-800 border-yellow-500' : ($homework->status === 'failed' ? 'bg-red-100 text-red-800 border-red-600' : 'bg-slate-100 text-slate-700')) }}">
            {{ ucfirst($homework->status) }}
        </span>
    </header>

    @if($homework->status === 'processing' || $homework->status === 'pending')
        <!-- Processing State -->
        <div class="max-w-xl" x-data="pollStatus('{{ route('homework.status', $homework) }}', '{{ route('homework.timeout', $homework) }}', '{{ csrf_token() }}')" x-init="startPolling()">
            <div class="bg-white border-2 border-slate-900 pixel-shadow-lg">
                <div class="h-1.5 bg-yellow-400 border-b-2 border-slate-900 animate-pulse"></div>
                <div class="p-10 flex flex-col items-center text-center">
                    <div class="w-16 h-16 border-4 border-slate-900 bg-yellow-100 flex items-center justify-center mb-6 relative">
                        <span class="material-symbols-outlined text-yellow-700 text-3xl animate-spin" style="animation-duration:2s;">settings</span>
                    </div>
                    <h3 class="font-headline-md text-headline-md text-slate-900 mb-2" style="font-family: Epilogue, sans-serif;">AI is generating your homework</h3>
                    <p class="font-body-md text-body-md text-slate-500 text-sm mb-6">Gemini is reading your lesson PDF and crafting the perfect assignment. This usually takes 30–60 seconds.</p>
                    <div class="w-full bg-slate-200 border-2 border-slate-900 h-3 mb-2">
                        <div class="bg-blue-500 h-full border-r-2 border-slate-900 transition-all duration-1000" :style="'width:' + progress + '%'"></div>
                    </div>
                    <p class="font-technical-xs text-technical-xs text-slate-400" x-text="statusText"></p>
                </div>
            </div>
        </div>

        <script>
        function pollStatus(statusUrl, timeoutUrl, csrfToken) {
            const MAX_SECONDS = 180;
            return {
                elapsed: 0,
                progress: 5,
                statusText: 'Auto-refreshing every 5 seconds...',
                startPolling() {
                    const interval = setInterval(async () => {
                        this.elapsed += 5;
                        this.progress = Math.min(95, Math.round((this.elapsed / MAX_SECONDS) * 100));
                        this.statusText = `${this.elapsed}s elapsed — auto-refreshing every 5 seconds...`;

                        if (this.elapsed >= MAX_SECONDS) {
                            clearInterval(interval);
                            this.statusText = 'Timed out. Marking as failed...';
                            await fetch(timeoutUrl, {
                                method: 'POST',
                                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
                            }).catch(() => {});
                            window.location.reload();
                            return;
                        }

                        try {
                            const res = await fetch(statusUrl, { headers: { 'Accept': 'application/json' } });
                            const data = await res.json();
                            if (data.status === 'completed' || data.status === 'failed') {
                                clearInterval(interval);
                                window.location.reload();
                            }
                        } catch (e) {}
                    }, 5000);
                }
            }
        }
        </script>

    @elseif($homework->status === 'failed')
        <!-- Failed State -->
        <div class="max-w-xl">
            <div class="bg-white border-2 border-red-600 pixel-shadow">
                <div class="h-1.5 bg-red-500 border-b-2 border-red-600"></div>
                <div class="p-8 flex flex-col items-center text-center">
                    <span class="material-symbols-outlined text-red-500 text-5xl mb-4">error</span>
                    <h3 class="font-headline-md text-headline-md text-slate-900 mb-2" style="font-family: Epilogue, sans-serif;">Generation Failed</h3>
                    <p class="font-technical-xs text-technical-xs text-red-700 bg-red-50 border border-red-300 px-4 py-3 mb-6 w-full text-left">{{ $homework->error_message ?? 'An unexpected error occurred.' }}</p>
                    <div class="flex gap-4">
                        <a href="{{ route('homework.create') }}"
                           class="flex items-center gap-2 px-6 py-3 bg-blue-600 text-white border-2 border-slate-900 pixel-shadow btn-hover transition-transform font-technical-xs text-technical-xs uppercase font-bold">
                            <span class="material-symbols-outlined text-[18px]">refresh</span>
                            Try Again
                        </a>
                        <form method="POST" action="{{ route('homework.destroy', $homework) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-6 py-3 border-2 border-red-600 text-red-700 font-technical-xs text-technical-xs uppercase font-bold hover:bg-red-50 transition-colors">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @elseif($homework->status === 'completed')
        <!-- Completed State -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6"
             x-data="homeworkRefine('{{ route('homework.refine', $homework) }}', '{{ csrf_token() }}')">

            <!-- Sidebar: info + downloads + refine -->
            <div class="space-y-4">
                <!-- Download Buttons -->
                <div class="bg-white border-2 border-slate-900 pixel-shadow">
                    <div class="h-1.5 bg-green-500 border-b-2 border-slate-900"></div>
                    <div class="p-5">
                        <h3 class="font-technical-sm text-technical-sm text-slate-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px] text-green-600">download</span>
                            Download
                        </h3>
                        <div class="space-y-3">
                            <a href="{{ route('homework.download', [$homework, 'pdf']) }}"
                               class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-red-500 text-white border-2 border-slate-900 pixel-shadow btn-hover transition-transform font-technical-xs text-technical-xs uppercase tracking-wider font-bold">
                                <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                                Download PDF
                            </a>
                            <a href="{{ route('homework.download', [$homework, 'docx']) }}"
                               class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-blue-600 text-white border-2 border-slate-900 pixel-shadow btn-hover transition-transform font-technical-xs text-technical-xs uppercase tracking-wider font-bold">
                                <span class="material-symbols-outlined text-[18px]">article</span>
                                Download DOCX
                            </a>
                        </div>
                    </div>
                </div>

                <!-- AI Refine Panel -->
                <div class="bg-white border-2 border-slate-900 pixel-shadow">
                    <div class="h-1.5 bg-blue-500 border-b-2 border-slate-900"></div>
                    <div class="p-5">
                        <h3 class="font-technical-sm text-technical-sm text-slate-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px] text-blue-600">auto_fix_high</span>
                            Refine with AI
                        </h3>

                        <!-- Quick suggestion chips -->
                        <div class="flex flex-wrap gap-1.5 mb-3">
                            @foreach([
                                'Add 5 more questions',
                                'Add an answer key',
                                'Make questions harder',
                                'Add a vocabulary section',
                                'Simplify the language',
                                'Add a bonus challenge question',
                            ] as $chip)
                                <button type="button"
                                        @click="instruction = '{{ $chip }}'"
                                        class="px-2 py-1 text-[11px] border border-slate-300 bg-slate-50 text-slate-600 hover:border-blue-500 hover:text-blue-600 hover:bg-blue-50 transition-colors font-medium">
                                    {{ $chip }}
                                </button>
                            @endforeach
                        </div>

                        <textarea
                            x-model="instruction"
                            rows="3"
                            placeholder="Tell AI how to improve this homework..."
                            class="w-full px-3 py-2 border-2 border-slate-900 bg-surface-container-low font-body-md text-body-md text-sm focus:outline-none focus:border-blue-600 resize-none placeholder-slate-400 mb-3"
                        ></textarea>

                        <!-- Error message -->
                        <p x-show="error" x-cloak x-text="error"
                           class="text-xs text-red-600 bg-red-50 border border-red-200 px-3 py-2 mb-3"></p>

                        <!-- Success flash -->
                        <p x-show="success" x-cloak
                           class="text-xs text-green-700 bg-green-50 border border-green-300 px-3 py-2 mb-3">
                            Homework updated successfully!
                        </p>

                        <button @click="refine()"
                                :disabled="loading || !instruction.trim()"
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 text-white border-2 border-slate-900 pixel-shadow font-technical-xs text-technical-xs uppercase font-bold transition-all hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none disabled:opacity-40 disabled:cursor-not-allowed disabled:translate-x-0 disabled:translate-y-0">
                            <span class="material-symbols-outlined text-[18px]" x-text="loading ? 'hourglass_top' : 'auto_fix_high'">auto_fix_high</span>
                            <span x-text="loading ? 'Refining...' : 'Apply Changes'">Apply Changes</span>
                        </button>
                    </div>
                </div>

                <!-- Instructions used -->
                <div class="bg-surface-container-low border-2 border-slate-900 p-5">
                    <h3 class="font-technical-sm text-technical-sm text-slate-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px] text-blue-600">edit_note</span>
                        Instructions Used
                    </h3>
                    <p class="font-technical-xs text-technical-xs text-slate-600 leading-relaxed">{{ $homework->instructions }}</p>
                </div>

                <!-- Delete -->
                <form method="POST" action="{{ route('homework.destroy', $homework) }}" onsubmit="return confirm('Delete this homework?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 border-2 border-red-600 text-red-700 font-technical-xs text-technical-xs uppercase font-bold hover:bg-red-50 transition-colors">
                        <span class="material-symbols-outlined text-[16px]">delete</span> Delete
                    </button>
                </form>
            </div>

            <!-- Main: preview -->
            <div class="lg:col-span-2">
                <div class="bg-white border-2 border-slate-900 pixel-shadow">
                    <div class="flex items-center justify-between px-5 py-3 border-b-2 border-slate-900">
                        <h3 class="font-technical-sm text-technical-sm text-slate-700 uppercase tracking-wider flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px] text-blue-600">preview</span>
                            Homework Preview
                        </h3>
                        <!-- Refining overlay indicator -->
                        <div x-show="loading" x-cloak class="flex items-center gap-2 font-technical-xs text-technical-xs text-blue-600">
                            <span class="material-symbols-outlined text-[16px] animate-spin">progress_activity</span>
                            AI is refining...
                        </div>
                    </div>
                    <div class="relative">
                        <!-- Loading overlay -->
                        <div x-show="loading" x-cloak
                             class="absolute inset-0 bg-white/70 z-10 flex items-center justify-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-10 h-10 border-4 border-slate-900 border-t-blue-600 rounded-full animate-spin"></div>
                                <p class="font-technical-xs text-technical-xs text-slate-600">Applying your changes...</p>
                            </div>
                        </div>
                        <div id="homework-preview"
                             class="p-6 prose prose-sm max-w-none font-body-md text-body-md text-sm leading-relaxed overflow-auto max-h-[70vh]"
                             style="font-family: 'Inter', 'Kantumruy Pro', sans-serif;">
                            {!! $homework->homework_content !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script>
        function homeworkRefine(refineUrl, csrfToken) {
            return {
                instruction: '',
                loading: false,
                error: '',
                success: false,

                async refine() {
                    if (!this.instruction.trim() || this.loading) return;
                    this.loading = true;
                    this.error = '';
                    this.success = false;

                    try {
                        const res = await fetch(refineUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ instruction: this.instruction }),
                        });

                        const data = await res.json();

                        if (!res.ok) {
                            this.error = data.error || 'Something went wrong. Please try again.';
                            return;
                        }

                        document.getElementById('homework-preview').innerHTML = data.content;
                        this.instruction = '';
                        this.success = true;
                        setTimeout(() => { this.success = false; }, 3000);
                    } catch (e) {
                        this.error = 'Network error. Please try again.';
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
        </script>
    @endif

</x-app-layout>
