<x-app-layout>

<div class="flex flex-col h-[calc(100vh-64px)] md:h-screen -m-8"
     x-data="chatApp({{ $conversation->id }}, '{{ csrf_token() }}')"
     x-init="scrollToBottom()">

    <!-- Chat Header -->
    <div class="flex items-center gap-4 px-6 py-4 bg-white border-b-4 border-slate-900 flex-shrink-0">
        <a href="{{ route('chat.index') }}" class="w-9 h-9 border-2 border-slate-900 flex items-center justify-center hover:bg-surface-container transition-colors">
            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
        </a>
        <div class="w-10 h-10 border-2 border-slate-900 bg-blue-600 flex items-center justify-center flex-shrink-0">
            <span class="material-symbols-outlined text-white text-[20px]" style="font-variation-settings: 'FILL' 1;">school</span>
        </div>
        <div class="flex-1 min-w-0">
            <h2 class="font-technical-sm text-technical-sm text-slate-900 font-bold truncate">{{ $conversation->title }}</h2>
            <p class="font-technical-xs text-technical-xs text-slate-400">Nova · AI Teaching Assistant</p>
        </div>
        <div class="flex items-center gap-2 px-3 py-1.5 border-2 border-slate-900 bg-green-50 font-technical-xs text-technical-xs text-green-700">
            <span class="w-2 h-2 bg-green-500 border border-slate-900 block rounded-full animate-pulse"></span>
            Nova Online
        </div>
    </div>

    <!-- Messages Area -->
    <div class="flex-1 overflow-y-auto px-4 md:px-8 py-6 space-y-6 bg-surface-container-low" id="messages-container">

        <!-- Nova intro if no messages -->
        @if($messages->count() === 0)
        <div class="flex justify-start gap-3">
            <div class="w-10 h-10 border-2 border-slate-900 bg-blue-600 flex items-center justify-center flex-shrink-0 self-end">
                <span class="material-symbols-outlined text-white text-[18px]" style="font-variation-settings: 'FILL' 1;">school</span>
            </div>
            <div class="max-w-[75%] bg-white border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] px-4 py-3">
                <p class="font-technical-xs text-technical-xs text-blue-600 font-bold mb-1">Nova</p>
                <p class="font-body-md text-body-md text-sm">Hey there! 👋 I'm Nova, your AI teaching assistant. I'm here to help you with lesson planning, explaining concepts, writing activities, quiz questions, and anything else you need. What are we working on today?</p>
            </div>
        </div>
        @endif

        <!-- Server-rendered existing messages -->
        @foreach($messages as $msg)
            <div class="flex {{ $msg->role === 'user' ? 'justify-end' : 'justify-start' }} gap-3">
                @if($msg->role === 'assistant')
                    <div class="w-10 h-10 border-2 border-slate-900 bg-blue-600 flex items-center justify-center flex-shrink-0 self-end">
                        <span class="material-symbols-outlined text-white text-[18px]" style="font-variation-settings: 'FILL' 1;">school</span>
                    </div>
                @endif
                <div class="max-w-[75%] {{ $msg->role === 'user'
                    ? 'bg-blue-600 text-white border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)]'
                    : 'bg-white border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)]' }} px-4 py-3">
                    @if($msg->role === 'assistant')
                        <p class="font-technical-xs text-technical-xs text-blue-600 font-bold mb-1">Nova</p>
                    @endif
                    @if($msg->role === 'assistant')
                        <div class="nova-markdown" data-md="{{ e($msg->content) }}"></div>
                    @else
                        <p class="font-body-md text-body-md text-sm whitespace-pre-wrap">{{ $msg->content }}</p>
                    @endif
                    <p class="font-technical-xs text-technical-xs mt-2 opacity-50 text-right text-[10px]">{{ $msg->created_at->format('H:i') }}</p>
                </div>
                @if($msg->role === 'user')
                    <div class="w-10 h-10 border-2 border-slate-900 bg-primary-fixed flex items-center justify-center flex-shrink-0 self-end">
                        <span class="material-symbols-outlined text-on-primary-fixed text-[18px]">person</span>
                    </div>
                @endif
            </div>
        @endforeach

        <!-- Dynamic messages (Alpine) -->
        <template x-for="msg in dynamicMessages" :key="msg.id">
            <div :class="msg.role === 'user' ? 'flex justify-end gap-3' : 'flex justify-start gap-3'">
                <template x-if="msg.role === 'assistant'">
                    <div class="w-10 h-10 border-2 border-slate-900 bg-blue-600 flex items-center justify-center flex-shrink-0 self-end">
                        <span class="material-symbols-outlined text-white text-[18px]" style="font-variation-settings: 'FILL' 1;">school</span>
                    </div>
                </template>
                <div :class="msg.role === 'user'
                    ? 'max-w-[75%] bg-blue-600 text-white border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] px-4 py-3'
                    : 'max-w-[75%] bg-white border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] px-4 py-3'">
                    <template x-if="msg.role === 'assistant'">
                        <p class="font-technical-xs text-technical-xs text-blue-600 font-bold mb-1">Nova</p>
                    </template>
                    <template x-if="msg.role === 'assistant'">
                        <div class="nova-markdown" x-html="renderMarkdown(msg.content)"></div>
                    </template>
                    <template x-if="msg.role === 'user'">
                        <p class="font-body-md text-body-md text-sm whitespace-pre-wrap" x-text="msg.content"></p>
                    </template>
                </div>
                <template x-if="msg.role === 'user'">
                    <div class="w-10 h-10 border-2 border-slate-900 bg-primary-fixed flex items-center justify-center flex-shrink-0 self-end">
                        <span class="material-symbols-outlined text-on-primary-fixed text-[18px]">person</span>
                    </div>
                </template>
            </div>
        </template>

        <!-- Typing indicator -->
        <div x-show="loading" x-cloak class="flex justify-start gap-3">
            <div class="w-10 h-10 border-2 border-slate-900 bg-blue-600 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-white text-[18px]" style="font-variation-settings: 'FILL' 1;">school</span>
            </div>
            <div class="bg-white border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] px-4 py-3 flex flex-col gap-1">
                <p class="font-technical-xs text-technical-xs text-blue-600 font-bold">Nova</p>
                <div class="flex items-center gap-1">
                    <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay:0ms"></span>
                    <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay:150ms"></span>
                    <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay:300ms"></span>
                </div>
            </div>
        </div>

        <div id="bottom-anchor"></div>
    </div>

    <!-- Quick Prompts -->
    <div class="px-4 md:px-8 py-2 bg-white border-t-2 border-dashed border-slate-200 flex gap-2 overflow-x-auto flex-shrink-0">
        @foreach([
            '📝 Help me write a lesson plan',
            '❓ Create quiz questions',
            '💡 Give me activity ideas',
            '📖 Explain this concept simply',
            '✅ Review my lesson objective',
        ] as $prompt)
            <button @click="input = '{{ $prompt }}'; $refs.msgInput.focus()"
                class="flex-shrink-0 px-3 py-1.5 border-2 border-slate-900 bg-surface-container-low font-technical-xs text-technical-xs text-slate-700 hover:bg-blue-50 hover:border-blue-600 hover:text-blue-700 transition-colors whitespace-nowrap">
                {{ $prompt }}
            </button>
        @endforeach
    </div>

    <!-- Input Bar -->
    <div class="px-4 md:px-8 py-4 bg-white border-t-4 border-slate-900 flex-shrink-0">
        <form @submit.prevent="sendMessage()" class="flex gap-3">
            <div class="flex-1 relative">
                <textarea
                    x-ref="msgInput"
                    x-model="input"
                    @keydown.enter.prevent="if (!$event.shiftKey) sendMessage()"
                    rows="1"
                    placeholder="Ask Nova anything about your lesson..."
                    class="w-full px-4 py-3 bg-surface-container-low border-2 border-slate-900 font-body-md text-body-md text-sm focus:outline-none focus:border-blue-600 focus:shadow-[4px_4px_0px_0px_#005ac2] transition-shadow resize-none placeholder-slate-400"
                    style="min-height: 48px; max-height: 200px; overflow-y: auto;"
                    @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                ></textarea>
            </div>
            <button type="submit"
                :disabled="loading || !input.trim()"
                class="px-5 py-3 bg-blue-600 text-white border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all font-technical-xs text-technical-xs disabled:opacity-40 disabled:cursor-not-allowed disabled:translate-x-0 disabled:translate-y-0 disabled:shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] flex items-center gap-2 self-end">
                <span class="material-symbols-outlined text-[20px]" x-text="loading ? 'hourglass_top' : 'send'">send</span>
                <span x-text="loading ? 'Thinking...' : 'Send'">Send</span>
            </button>
        </form>
        <p class="font-technical-xs text-technical-xs text-slate-400 mt-2">Shift+Enter for new line · Nova remembers your past conversations</p>
    </div>

</div>

<style>
.nova-markdown { font-size: 0.875rem; line-height: 1.6; color: #1e293b; }
.nova-markdown p { margin: 0 0 0.5rem; }
.nova-markdown p:last-child { margin-bottom: 0; }
.nova-markdown strong { font-weight: 700; }
.nova-markdown em { font-style: italic; }
.nova-markdown ul { list-style-type: disc; padding-left: 1.25rem; margin: 0.5rem 0; }
.nova-markdown ol { list-style-type: decimal; padding-left: 1.25rem; margin: 0.5rem 0; }
.nova-markdown li { margin: 0.2rem 0; }
.nova-markdown code { background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 3px; padding: 0.1em 0.3em; font-size: 0.8em; font-family: monospace; }
.nova-markdown pre { background: #f1f5f9; border: 1px solid #e2e8f0; padding: 0.75rem; margin: 0.5rem 0; overflow-x: auto; }
.nova-markdown pre code { background: none; border: none; padding: 0; }
.nova-markdown h1,.nova-markdown h2,.nova-markdown h3 { font-weight: 700; margin: 0.75rem 0 0.25rem; }
.nova-markdown h1 { font-size: 1.1rem; }
.nova-markdown h2 { font-size: 1rem; }
.nova-markdown h3 { font-size: 0.9rem; }
.nova-markdown hr { border: none; border-top: 1px solid #e2e8f0; margin: 0.75rem 0; }
</style>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
function renderMarkdown(text) {
    return marked.parse(text || '', { breaks: true, gfm: true });
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.nova-markdown[data-md]').forEach(el => {
        el.innerHTML = renderMarkdown(el.dataset.md);
        el.removeAttribute('data-md');
    });
});

function chatApp(conversationId, csrfToken) {
    return {
        input: '',
        loading: false,
        dynamicMessages: [],
        msgCount: 0,

        scrollToBottom() {
            this.$nextTick(() => {
                const anchor = document.getElementById('bottom-anchor');
                if (anchor) anchor.scrollIntoView({ behavior: 'smooth' });
            });
        },

        async sendMessage() {
            const text = this.input.trim();
            if (!text || this.loading) return;

            this.input = '';
            this.loading = true;
            this.dynamicMessages.push({ id: ++this.msgCount, role: 'user', content: text });
            this.scrollToBottom();

            const ta = this.$refs.msgInput;
            if (ta) ta.style.height = 'auto';

            try {
                const res = await fetch(`/chat/${conversationId}/message`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ message: text }),
                });

                const data = await res.json();
                this.dynamicMessages.push({
                    id: ++this.msgCount,
                    role: 'assistant',
                    content: data.message?.content ?? 'Sorry, I had trouble responding. Please try again.'
                });
            } catch (e) {
                this.dynamicMessages.push({
                    id: ++this.msgCount,
                    role: 'assistant',
                    content: 'Sorry, something went wrong. Please try again.'
                });
            } finally {
                this.loading = false;
                this.scrollToBottom();
            }
        }
    }
}
</script>

</x-app-layout>
