<x-app-layout>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" />

    <div x-data="statusPoller('{{ route('components.status', $item) }}', '{{ $item->status }}')"
         x-init="init()">

        <!-- Header -->
        <header class="flex justify-between items-start mb-8 gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('projects.show', $item->project) }}"
                   class="w-10 h-10 border-2 border-slate-900 bg-white flex items-center justify-center pixel-shadow btn-hover transition-transform flex-shrink-0">
                    <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                </a>
                <div>
                    <h2 class="font-headline-xl text-headline-xl text-slate-900" style="font-family: Epilogue, sans-serif;">{{ $item->name }}</h2>
                    <p class="font-technical-sm text-technical-sm text-slate-500 mt-1" style="font-family: 'Space Grotesk', sans-serif;">
                        <span class="material-symbols-outlined text-[14px] align-middle">folder_open</span>
                        {{ $item->project->name }}
                        <span class="mx-2 text-slate-300">·</span>
                        <span class="uppercase font-bold">{{ $item->framework }}</span>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3 flex-shrink-0">
                <!-- Status badge -->
                <div class="flex items-center gap-2 border-2 border-slate-900 px-4 py-2 bg-white pixel-shadow"
                     :class="{
                        'bg-yellow-50 border-yellow-600': status === 'pending',
                        'bg-blue-50 border-blue-600': status === 'processing',
                        'bg-green-50 border-green-600': status === 'done',
                        'bg-red-50 border-red-600': status === 'error'
                     }">
                    <span x-show="status === 'processing'" class="material-symbols-outlined text-[16px] text-blue-600 animate-spin">sync</span>
                    <span x-show="status === 'pending'"    class="material-symbols-outlined text-[16px] text-yellow-600">schedule</span>
                    <span x-show="status === 'done'"       class="material-symbols-outlined text-[16px] text-green-600">check_circle</span>
                    <span x-show="status === 'error'"      class="material-symbols-outlined text-[16px] text-red-600">error</span>
                    <span x-text="status" class="font-technical-xs text-technical-xs font-bold capitalize" style="font-family: 'Space Grotesk', sans-serif;"></span>
                </div>

                <form method="POST" action="{{ route('components.destroy', $item) }}"
                      onsubmit="return confirm('Delete this component?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="border-2 border-error bg-white text-error px-4 py-2 font-technical-xs text-technical-xs font-bold shadow-[4px_4px_0px_0px_rgba(186,26,26,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all duration-75 sketch-border inline-flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px]">delete</span>
                        Delete
                    </button>
                </form>
            </div>
        </header>

        @if (session('success'))
            <div class="mb-6 p-4 border-2 border-green-600 bg-green-50 text-green-800 font-technical-sm text-technical-sm flex items-center gap-3 shadow-[4px_4px_0px_0px_rgba(22,101,52,1)]" style="font-family: 'Space Grotesk', sans-serif;">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        <!-- Meta bar -->
        <div class="border-2 border-slate-900 bg-white pixel-shadow flex items-center justify-between px-5 py-3 mb-6 flex-wrap gap-3">
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2 font-technical-xs text-technical-xs text-slate-500" style="font-family: 'Space Grotesk', sans-serif;">
                    <span class="material-symbols-outlined text-[16px]">update</span>
                    Updated {{ $item->updated_at->diffForHumans() }}
                </div>
                @if ($item->figma_node_id)
                    <div class="flex items-center gap-2 font-technical-xs text-technical-xs text-slate-500" style="font-family: 'Space Grotesk', sans-serif;">
                        <span class="material-symbols-outlined text-[16px]">tag</span>
                        Node: {{ $item->figma_node_id }}
                    </div>
                @endif
            </div>
            <a href="{{ $item->figma_url }}" target="_blank" rel="noopener"
               class="border-2 border-slate-900 bg-surface-container-low px-4 py-2 font-technical-xs text-technical-xs font-bold hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all duration-75 sketch-border inline-flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                View in Figma
            </a>
        </div>

        <!-- Main 2-column layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

            <!-- Generated Code Panel -->
            <div class="border-2 border-slate-900 bg-white pixel-shadow-lg flex flex-col overflow-hidden sketch-border">
                <div class="flex items-center justify-between px-5 py-3 border-b-2 border-slate-900 bg-surface-container-low">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px] text-primary">data_object</span>
                        <h3 class="font-technical-sm text-technical-sm font-bold text-slate-900 uppercase tracking-wider" style="font-family: 'Space Grotesk', sans-serif;">Generated Code</h3>
                    </div>
                    @if ($item->generated_code)
                        <button onclick="copyCode()"
                                class="border-2 border-slate-900 px-3 py-1 bg-white font-technical-xs text-technical-xs font-bold hover:bg-primary hover:text-white transition-colors inline-flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">content_copy</span>
                            <span id="copy-label">Copy</span>
                        </button>
                    @endif
                </div>

                <div class="flex-1 overflow-auto bg-slate-900" style="min-height: 420px; max-height: 580px;">
                    @if ($item->generated_code)
                        <pre id="code-block" class="m-0 h-full text-sm"><code class="language-{{ $item->framework === 'vue' ? 'html' : 'jsx' }}">{{ htmlspecialchars($item->generated_code) }}</code></pre>
                    @else
                        <div class="flex items-center justify-center h-full p-8 text-center" x-show="status !== 'done'">
                            <div>
                                <template x-if="status === 'processing'">
                                    <div class="flex flex-col items-center gap-4">
                                        <!-- 8-bit loading bar -->
                                        <div class="w-48 border-2 border-white h-6 relative overflow-hidden">
                                            <div class="absolute inset-0 bg-blue-500 animate-pulse" style="width: 60%;"></div>
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <span class="font-technical-xs text-technical-xs text-white" style="font-family: 'Space Grotesk', sans-serif;">GENERATING...</span>
                                            </div>
                                        </div>
                                        <p class="font-technical-sm text-technical-sm text-slate-400" style="font-family: 'Space Grotesk', sans-serif;">Parsing your Figma blueprint…</p>
                                    </div>
                                </template>
                                <template x-if="status === 'pending'">
                                    <div class="flex flex-col items-center gap-3">
                                        <span class="material-symbols-outlined text-[48px] text-slate-600">hourglass_empty</span>
                                        <p class="font-technical-sm text-technical-sm text-slate-400" style="font-family: 'Space Grotesk', sans-serif;">Queued for processing…</p>
                                    </div>
                                </template>
                                <template x-if="status === 'error'">
                                    <div class="flex flex-col items-center gap-3">
                                        <span class="material-symbols-outlined text-[48px] text-red-500">error</span>
                                        <p class="font-technical-sm text-technical-sm text-red-400" style="font-family: 'Space Grotesk', sans-serif;">Generation failed. Check logs below.</p>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div x-show="status === 'done'" class="p-6 text-center">
                            <p class="font-technical-sm text-technical-sm text-slate-400" style="font-family: 'Space Grotesk', sans-serif;">Code ready — reload to view.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Figma Preview Panel -->
            <div class="border-2 border-slate-900 bg-white pixel-shadow-lg flex flex-col overflow-hidden sketch-border">
                <div class="flex items-center gap-2 px-5 py-3 border-b-2 border-slate-900 bg-surface-container-low">
                    <span class="material-symbols-outlined text-[18px] text-primary">imagesmode</span>
                    <h3 class="font-technical-sm text-technical-sm font-bold text-slate-900 uppercase tracking-wider" style="font-family: 'Space Grotesk', sans-serif;">Figma Preview</h3>
                </div>
                <div class="flex-1 flex items-center justify-center p-6 bg-white" style="min-height: 420px;">
                    @if ($item->thumbnail_url)
                        <img src="{{ $item->thumbnail_url }}" alt="{{ $item->name }}"
                             class="max-w-full max-h-full object-contain border-2 border-slate-200" />
                    @else
                        <div class="flex flex-col items-center gap-4 text-slate-400">
                            <div class="w-24 h-24 border-4 border-dashed border-slate-300 flex items-center justify-center sketch-border">
                                <span class="material-symbols-outlined text-[40px]">image_not_supported</span>
                            </div>
                            <p class="font-technical-sm text-technical-sm text-center" style="font-family: 'Space Grotesk', sans-serif;">No thumbnail available</p>
                            <a href="{{ $item->figma_url }}" target="_blank" rel="noopener"
                               class="border-2 border-slate-400 px-4 py-2 font-technical-xs text-technical-xs hover:border-primary hover:text-primary transition-colors inline-flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                                Open in Figma
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Activity Log -->
        @if ($item->logs->isNotEmpty())
            <div class="border-2 border-slate-900 bg-white pixel-shadow sketch-border overflow-hidden">
                <div class="flex items-center gap-2 px-5 py-3 border-b-2 border-slate-900 bg-surface-container-low">
                    <span class="material-symbols-outlined text-[18px] text-primary">receipt_long</span>
                    <h3 class="font-technical-sm text-technical-sm font-bold text-slate-900 uppercase tracking-wider" style="font-family: 'Space Grotesk', sans-serif;">Activity Log</h3>
                </div>
                <ul class="divide-y-2 divide-dashed divide-slate-100">
                    @foreach ($item->logs->sortByDesc('created_at') as $log)
                        <li class="px-5 py-3 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                @php
                                    $dotMap = ['processing' => 'bg-blue-500', 'done' => 'bg-green-500', 'error' => 'bg-red-500'];
                                @endphp
                                <span class="w-2 h-2 border border-slate-900 {{ $dotMap[$log->status] ?? 'bg-slate-400' }} flex-shrink-0"></span>
                                <span class="font-technical-sm text-technical-sm text-slate-800 capitalize" style="font-family: 'Space Grotesk', sans-serif;">{{ $log->status }}</span>
                                @if ($log->message)
                                    <span class="font-technical-xs text-technical-xs text-slate-400" style="font-family: 'Space Grotesk', sans-serif;">— {{ $log->message }}</span>
                                @endif
                            </div>
                            <span class="font-technical-xs text-technical-xs text-slate-400 whitespace-nowrap" style="font-family: 'Space Grotesk', sans-serif;">{{ $log->created_at->diffForHumans() }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js" defer></script>

    <script>
        function statusPoller(statusUrl, initialStatus) {
            return {
                status: initialStatus,
                pollInterval: null,
                init() {
                    if (this.status === 'pending' || this.status === 'processing') this.startPolling();
                },
                startPolling() {
                    this.pollInterval = setInterval(async () => {
                        try {
                            const res = await fetch(statusUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                            const data = await res.json();
                            this.status = data.status;
                            if (data.status === 'done' || data.status === 'error') {
                                clearInterval(this.pollInterval);
                                if (data.status === 'done') window.location.reload();
                            }
                        } catch (e) {}
                    }, 3000);
                },
            };
        }

        function copyCode() {
            const code = document.getElementById('code-block')?.innerText ?? '';
            navigator.clipboard.writeText(code).then(() => {
                const label = document.getElementById('copy-label');
                label.textContent = 'Copied!';
                setTimeout(() => label.textContent = 'Copy', 2000);
            });
        }
    </script>

</x-app-layout>
