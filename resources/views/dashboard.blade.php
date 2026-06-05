<x-app-layout>

    <header class="flex justify-between items-center mb-12">
        <div class="flex items-center gap-4">
            <h2 class="font-headline-xl text-headline-xl text-slate-900" style="font-family: Epilogue, sans-serif;">Dashboard</h2>
            <div class="hidden lg:flex items-center gap-2 bg-surface-container-high px-3 py-1 border-2 border-slate-900 font-technical-xs text-technical-xs text-slate-700">
                <span class="w-2 h-2 bg-green-500 border border-slate-900 block"></span>
                AI Online
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('chat.store') }}"
               onclick="event.preventDefault(); document.getElementById('new-chat-form').submit();"
               class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white border-2 border-slate-900 pixel-shadow btn-hover transition-transform font-technical-xs text-technical-xs uppercase tracking-wider font-bold">
                <span class="material-symbols-outlined text-[18px]">chat</span>
                New Chat
            </a>
            <a href="{{ route('homework.create') }}"
               class="flex items-center gap-2 px-4 py-2 bg-yellow-300 text-slate-900 border-2 border-slate-900 pixel-shadow btn-hover transition-transform font-technical-xs text-technical-xs uppercase tracking-wider font-bold">
                <span class="material-symbols-outlined text-[18px]">assignment_add</span>
                New Homework
            </a>
        </div>
    </header>

    <form id="new-chat-form" method="POST" action="{{ route('chat.store') }}" class="hidden">@csrf</form>

    <!-- Stats -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-surface-container-low p-6 wobbly-border pixel-shadow-lg relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 bg-blue-100 border-l-2 border-b-2 border-slate-900 -mr-8 -mt-8 rotate-45"></div>
            <h3 class="font-technical-sm text-technical-sm text-slate-600 uppercase mb-2">Total Conversations</h3>
            <p class="font-headline-lg text-headline-lg text-slate-900">{{ auth()->user()->conversations()->count() }}</p>
            <div class="mt-4 flex items-center gap-2 font-technical-xs text-technical-xs text-blue-600">
                <span class="px-2 py-1 bg-white border-2 border-slate-900">AI Teacher Assistant</span>
            </div>
        </div>

        <div class="bg-surface p-6 border-2 border-slate-900 pixel-shadow relative">
            <h3 class="font-technical-sm text-technical-sm text-slate-600 uppercase mb-2">Homeworks Generated</h3>
            <p class="font-headline-lg text-headline-lg text-slate-900">{{ auth()->user()->homeworkRequests()->where('status', 'completed')->count() }}</p>
            <div class="mt-4 w-full bg-slate-200 border-2 border-slate-900 h-4">
                @php $total = auth()->user()->homeworkRequests()->count(); $done = auth()->user()->homeworkRequests()->where('status','completed')->count(); @endphp
                <div class="bg-blue-500 h-full border-r-2 border-slate-900 transition-all" style="width: {{ $total > 0 ? min(100, ($done/$total)*100) : 0 }}%"></div>
            </div>
            <p class="mt-2 font-technical-xs text-technical-xs text-right text-slate-500">{{ $total }} total requests</p>
        </div>

        <div class="bg-blue-600 text-white p-6 border-2 border-slate-900 pixel-shadow-lg flex flex-col justify-center items-center text-center">
            <span class="material-symbols-outlined text-5xl mb-3" style="font-variation-settings: 'FILL' 1;">school</span>
            <h3 class="font-headline-md text-headline-md mb-2" style="font-family: Epilogue, sans-serif;">Generate Homework</h3>
            <p class="font-body-md text-body-md mb-4 opacity-90 text-sm">Upload a lesson PDF and let AI craft the perfect homework.</p>
            <a href="{{ route('homework.create') }}"
               class="px-6 py-2 bg-yellow-300 text-slate-900 border-2 border-slate-900 pixel-shadow btn-hover transition-transform font-technical-xs text-technical-xs uppercase tracking-wider font-bold w-full text-center block">
                Upload Lesson PDF
            </a>
        </div>
    </section>

    <!-- Recent Conversations -->
    <section class="mb-12">
        <div class="flex justify-between items-end mb-6 border-b-4 border-slate-900 pb-2">
            <h2 class="font-headline-lg text-headline-lg text-slate-900" style="font-family: Epilogue, sans-serif;">Recent Conversations</h2>
            <a href="{{ route('chat.index') }}" class="font-technical-sm text-technical-sm text-blue-600 hover:underline decoration-2 underline-offset-4">View All</a>
        </div>
        @php $recentChats = auth()->user()->conversations()->latest()->take(4)->get(); @endphp
        @if($recentChats->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($recentChats as $conv)
                    <a href="{{ route('chat.show', $conv) }}"
                       class="bg-white p-4 wobbly-border pixel-shadow hover:-translate-y-1 hover:pixel-shadow-lg transition-all group block">
                        <div class="w-10 h-10 border-2 border-slate-900 bg-blue-100 flex items-center justify-center mb-3">
                            <span class="material-symbols-outlined text-blue-600" style="font-variation-settings: 'FILL' 1;">chat</span>
                        </div>
                        <h3 class="font-technical-sm text-technical-sm text-slate-900 truncate font-bold mb-1">{{ $conv->title }}</h3>
                        <p class="font-technical-xs text-technical-xs text-slate-400">{{ $conv->messages()->count() }} messages · {{ $conv->updated_at->diffForHumans() }}</p>
                    </a>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-12 border-4 border-dashed border-outline-variant sketch-border bg-surface-container-low">
                <span class="material-symbols-outlined text-5xl text-slate-300 mb-3">chat</span>
                <p class="font-technical-sm text-technical-sm text-slate-500 mb-4">No conversations yet.</p>
                <form method="POST" action="{{ route('chat.store') }}">
                    @csrf
                    <button type="submit" class="border-2 border-slate-900 bg-primary text-on-primary px-6 py-3 font-technical-xs text-technical-xs font-bold pixel-shadow btn-hover transition-all">
                        Start First Chat
                    </button>
                </form>
            </div>
        @endif
    </section>

    <!-- Recent Homework -->
    <section>
        <div class="flex justify-between items-end mb-6 border-b-4 border-slate-900 pb-2">
            <h2 class="font-headline-lg text-headline-lg text-slate-900" style="font-family: Epilogue, sans-serif;">Recent Homework</h2>
            <a href="{{ route('homework.index') }}" class="font-technical-sm text-technical-sm text-blue-600 hover:underline decoration-2 underline-offset-4">View All</a>
        </div>
        @php $recentHw = auth()->user()->homeworkRequests()->latest()->take(4)->get(); @endphp
        @if($recentHw->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($recentHw as $hw)
                    <a href="{{ route('homework.show', $hw) }}"
                       class="bg-white p-4 border-2 border-slate-900 pixel-shadow hover:-translate-y-1 hover:pixel-shadow-lg transition-all block">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="material-symbols-outlined text-slate-700" style="font-variation-settings: 'FILL' 1;">description</span>
                            <span class="px-2 py-0.5 border border-slate-900 font-technical-xs text-technical-xs
                                {{ $hw->status === 'completed' ? 'bg-green-100 text-green-800' : ($hw->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : ($hw->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-slate-100 text-slate-700')) }}">
                                {{ ucfirst($hw->status) }}
                            </span>
                        </div>
                        <h3 class="font-technical-sm text-technical-sm text-slate-900 truncate font-bold mb-1">{{ $hw->original_filename }}</h3>
                        <p class="font-technical-xs text-technical-xs text-slate-400">{{ $hw->created_at->diffForHumans() }}</p>
                    </a>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-12 border-4 border-dashed border-outline-variant sketch-border bg-surface-container-low">
                <span class="material-symbols-outlined text-5xl text-slate-300 mb-3">assignment</span>
                <p class="font-technical-sm text-technical-sm text-slate-500 mb-4">No homework generated yet.</p>
                <a href="{{ route('homework.create') }}"
                   class="border-2 border-slate-900 bg-primary text-on-primary px-6 py-3 font-technical-xs text-technical-xs font-bold pixel-shadow btn-hover transition-all">
                    Generate First Homework
                </a>
            </div>
        @endif
    </section>

</x-app-layout>
