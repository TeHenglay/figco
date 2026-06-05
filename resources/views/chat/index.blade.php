<x-app-layout>

    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="font-headline-xl text-headline-xl text-slate-900" style="font-family: Epilogue, sans-serif;">{{ __('AI Assistant') }}</h2>
            <p class="font-technical-sm text-technical-sm text-slate-500 mt-1">Your personal teacher assistant — ask anything</p>
        </div>
        <form method="POST" action="{{ route('chat.store') }}">
            @csrf
            <button type="submit"
                class="flex items-center gap-2 px-5 py-3 bg-blue-600 text-white border-2 border-slate-900 pixel-shadow btn-hover transition-transform font-technical-xs text-technical-xs uppercase tracking-wider font-bold">
                <span class="material-symbols-outlined text-[18px]">add</span>
                New Chat
            </button>
        </form>
    </header>

    @if($conversations->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($conversations as $conv)
                <div class="bg-white border-2 border-slate-900 pixel-shadow group relative">
                    <div class="h-1.5 bg-blue-500 border-b-2 border-slate-900"></div>
                    <a href="{{ route('chat.show', $conv) }}" class="block p-5">
                        <div class="flex items-start gap-3 mb-4">
                            <div class="w-10 h-10 border-2 border-slate-900 bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-blue-600 text-[20px]" style="font-variation-settings: 'FILL' 1;">chat</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="font-technical-sm text-technical-sm text-slate-900 font-bold truncate">{{ $conv->title }}</h3>
                                <p class="font-technical-xs text-technical-xs text-slate-400 mt-0.5">{{ $conv->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-1 bg-surface-container border border-slate-900 font-technical-xs text-technical-xs text-slate-600">
                                {{ $conv->messages()->count() }} messages
                            </span>
                        </div>
                    </a>
                    <div class="border-t-2 border-slate-100 px-5 py-3 flex justify-end">
                        <form method="POST" action="{{ route('chat.destroy', $conv) }}" onsubmit="return confirm('Delete this conversation?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="font-technical-xs text-technical-xs text-red-500 hover:text-red-700 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">delete</span> {{ __('Delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-24 border-4 border-dashed border-outline-variant sketch-border bg-surface-container-low">
            <div class="w-20 h-20 border-4 border-slate-900 bg-primary-fixed flex items-center justify-center sketch-border mb-6 shadow-[6px_6px_0px_0px_rgba(30,41,59,1)]">
                <span class="material-symbols-outlined text-[40px] text-on-primary-fixed">chat</span>
            </div>
            <h3 class="font-headline-md text-headline-md text-on-background mb-2" style="font-family: Epilogue, sans-serif;">No conversations yet</h3>
            <p class="font-body-md text-body-md text-on-surface-variant mb-8 text-center max-w-sm">Start chatting with your AI teacher assistant. Ask questions, get explanations, brainstorm ideas.</p>
            <form method="POST" action="{{ route('chat.store') }}">
                @csrf
                <button type="submit"
                    class="border-2 border-slate-900 bg-primary text-on-primary px-8 py-4 font-technical-sm text-technical-sm font-bold shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[4px] hover:translate-y-[4px] hover:shadow-none transition-all duration-75 sketch-border inline-flex items-center gap-2">
                    <span class="material-symbols-outlined">add</span>
                    Start Your First Chat
                </button>
            </form>
        </div>
    @endif

</x-app-layout>
