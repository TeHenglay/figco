<x-app-layout>

    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="font-headline-xl text-headline-xl text-slate-900" style="font-family: Epilogue, sans-serif;">Homework Generator</h2>
            <p class="font-technical-sm text-technical-sm text-slate-500 mt-1">Upload a lesson PDF and AI generates homework instantly</p>
        </div>
        <a href="{{ route('homework.create') }}"
           class="flex items-center gap-2 px-5 py-3 bg-yellow-300 text-slate-900 border-2 border-slate-900 pixel-shadow btn-hover transition-transform font-technical-xs text-technical-xs uppercase tracking-wider font-bold">
            <span class="material-symbols-outlined text-[18px]">upload_file</span>
            New Homework
        </a>
    </header>

    @if($requests->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($requests as $hw)
                <div class="bg-white border-2 border-slate-900 pixel-shadow group">
                    <div class="h-1.5 border-b-2 border-slate-900
                        {{ $hw->status === 'completed' ? 'bg-green-500' : ($hw->status === 'processing' ? 'bg-yellow-400' : ($hw->status === 'failed' ? 'bg-red-500' : 'bg-slate-400')) }}">
                    </div>
                    <a href="{{ route('homework.show', $hw) }}" class="block p-5">
                        <div class="flex items-start gap-3 mb-4">
                            <div class="w-10 h-10 border-2 border-slate-900 bg-surface-container flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-slate-600 text-[20px]" style="font-variation-settings: 'FILL' 1;">description</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="font-technical-sm text-technical-sm text-slate-900 font-bold truncate">{{ $hw->original_filename }}</h3>
                                <p class="font-technical-xs text-technical-xs text-slate-400 mt-0.5">{{ $hw->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <p class="font-technical-xs text-technical-xs text-slate-600 line-clamp-2 mb-4">{{ $hw->instructions }}</p>
                        <span class="px-2 py-1 border border-slate-900 font-technical-xs text-technical-xs
                            {{ $hw->status === 'completed' ? 'bg-green-100 text-green-800' : ($hw->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : ($hw->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-slate-100 text-slate-600')) }}">
                            {{ ucfirst($hw->status) }}
                        </span>
                    </a>
                    @if($hw->status === 'completed')
                        <div class="border-t-2 border-slate-100 px-5 py-3 flex gap-2">
                            <a href="{{ route('homework.download', [$hw, 'pdf']) }}"
                               class="flex-1 flex items-center justify-center gap-1 px-3 py-2 bg-red-50 border-2 border-slate-900 font-technical-xs text-technical-xs text-red-800 hover:bg-red-100 transition-colors">
                                <span class="material-symbols-outlined text-[16px]">picture_as_pdf</span> PDF
                            </a>
                            <a href="{{ route('homework.download', [$hw, 'docx']) }}"
                               class="flex-1 flex items-center justify-center gap-1 px-3 py-2 bg-blue-50 border-2 border-slate-900 font-technical-xs text-technical-xs text-blue-800 hover:bg-blue-100 transition-colors">
                                <span class="material-symbols-outlined text-[16px]">article</span> DOCX
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-8">{{ $requests->links() }}</div>
    @else
        <div class="flex flex-col items-center justify-center py-24 border-4 border-dashed border-outline-variant sketch-border bg-surface-container-low">
            <div class="w-20 h-20 border-4 border-slate-900 bg-primary-fixed flex items-center justify-center sketch-border mb-6 shadow-[6px_6px_0px_0px_rgba(30,41,59,1)]">
                <span class="material-symbols-outlined text-[40px] text-on-primary-fixed">assignment</span>
            </div>
            <h3 class="font-headline-md text-headline-md text-on-background mb-2" style="font-family: Epilogue, sans-serif;">No homework generated yet</h3>
            <p class="font-body-md text-body-md text-on-surface-variant mb-8 text-center max-w-sm">Upload a lesson PDF, describe what you need, and let AI generate a complete homework assignment.</p>
            <a href="{{ route('homework.create') }}"
               class="border-2 border-slate-900 bg-primary text-on-primary px-8 py-4 font-technical-sm text-technical-sm font-bold shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none transition-all duration-75 sketch-border inline-flex items-center gap-2">
                <span class="material-symbols-outlined">upload_file</span>
                Generate First Homework
            </a>
        </div>
    @endif

</x-app-layout>
