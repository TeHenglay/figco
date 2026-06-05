<x-app-layout>

<div class="flex flex-col h-[calc(100vh-64px)] md:h-screen -m-8">

    <!-- Chat Header -->
    <div class="flex items-center gap-4 px-6 py-4 bg-white border-b-4 border-slate-900 flex-shrink-0">
        <a href="{{ route('chat.index') }}" class="w-9 h-9 border-2 border-slate-900 flex items-center justify-center hover:bg-surface-container transition-colors">
            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
        </a>
        <div class="flex-1 min-w-0">
            <h2 class="font-technical-sm text-technical-sm text-slate-900 font-bold truncate">{{ $conversation->title }}</h2>
            <p class="font-technical-xs text-technical-xs text-slate-400">{{ $messages->count() }} messages</p>
        </div>
        <div class="flex items-center gap-2 px-3 py-1.5 border-2 border-slate-900 bg-green-50 font-technical-xs text-technical-xs text-green-700">
            <span class="w-2 h-2 bg-green-500 border border-slate-900 block rounded-full"></span>
            AI Active
        </div>
    </div>

    <!-- Messages Area -->
    <div class="flex-1 overflow-y-auto px-6 py-6 space-y-4 bg-surface-container-low" id="messages-container"
         x-data="chatApp({{ $conversation->id }}, '{{ csrf_token() }}')"
         x-init="scrollToBottom()">

        <!-- Existing messages -->
        @foreach($messages as $msg)
            <div class="flex {{ $msg->role === 'user' ? 'justify-end' : 'justify-start' }} gap-3">
                @if($msg->role === 'assistant')
                    <div class="w-8 h-8 border-2 border-slate-900 bg-blue-600 flex items-center justify-center flex-shrink-0 self-end">
                        <span class="material-symbols-outlined text-white text-[16px]" style="font-variation-settings: 'FILL' 1;">school</span>
                    </div>
                @endif
                <div class="max-w-[70%] {{ $msg->role === 'user'
                    ? 'bg-blue-600 text-white border-2 border-slate-900 pixel-shadow'
                    : 'bg-white border-2 border-slate-900 pixel-shadow' }} px-4 py-3">
                    <p class="font-body-md text-body-md text-sm whitespace-pre-wrap">{{ $msg->content }}</p>
                    <p class="font-technical-xs text-technical-xs mt-2 opacity-60 text-right text-[10px]">{{ $msg->created_at->format('H:i') }}</p>
                </div>
                @if($msg->role === 'user')
                    <div class="w-8 h-8 border-2 border-slate-900 bg-primary-fixed flex items-center justify-center flex-shrink-0 self-end">
                        <span class="material-symbols-outlined text-on-primary-fixed text-[16px]">person</span>
                    </div>
                @endif
            </div>
        @endforeach

        <!-- Dynamic messages (Alpine) -->
        <template x-for="msg in dynamicMessages" :key="msg.id">
            <div :class="msg.role === 'user' ? 'flex justify-end gap-3' : 'flex justify-start gap-3'">
                <template x-if="msg.role === 'assistant'">
                    <div class="w-8 h-8 border-2 border-slate-900 bg-blue-600 flex items-center justify-center flex-shrink-0 self-end">
                        <span class="material-symbols-outlined text-white text-[16px]" style="font-variation-settings: 'FILL' 1;">school</span>
                    </div>
                </template>
                <div :class="msg.role === 'user'
                    ? 'max-w-[70%] bg-blue-600 text-white border-2 border-slate-900 pixel-shadow px-4 py-3'
                    : 'max-w-[70%] bg-white border-2 border-slate-900 pixel-shadow px-4 py-3'">
                    <p class="font-body-md text-body-md text-sm whitespace-pre-wrap" x-text="msg.content"></p>
                </div>
                <template x-if="msg.role === 'user'">
                    <div class="w-8 h-8 border-2 border-slate-900 bg-primary-fixed flex items-center justify-center flex-shrink-0 self-end">
                        <span class="material-symbols-outlined text-on-primary-fixed text-[16px]">person</span>
                    </div>
                </template>
            </div>
        </template>

        <!-- Typing indicator -->
        <div x-show="loading" x-cloak class="flex justify-start gap-3">
            <div class="w-8 h-8 border-2 border-slate-900 bg-blue-600 flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-white text-[16px]" style="font-variation-settings: 'FILL' 1;">school</span>
            </div>
            <div class="bg-white border-2 border-slate-900 px-4 py-3 pixel-shadow flex items-center gap-1">
                <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay:0ms"></span>
                <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay:150ms"></span>
                <span class="w-2 h-2 bg-slate-400 rounded-full animate-bounce" style="animation-delay:300ms"></span>
            </div>
        </div>

        <!-- Scroll anchor -->
        <div id="bottom-anchor"></div>
    </div>

    <!-- Input Bar -->
    <div class="px-6 py-4 bg-white border-t-4 border-slate-900 flex-shrink-0"
         x-data x-on:keydown.window="$dispatch('focus-input')">
        <form @submit.prevent="sendMessage()" class="flex gap-3">
            <div class="flex-1 relative">
                <textarea
                    x-ref="msgInput"
                    x-model="input"
                    @keydown.enter.prevent="if (!$event.shiftKey) sendMessage()"
                    @keydown.window.focus-input="$el.focus()"
                    rows="1"
                    placeholder="Ask your AI assistant anything... (Enter to send, Shift+Enter for new line)"
                    class="w-full px-4 py-3 bg-surface-container-low border-2 border-slate-900 font-body-md text-body-md text-sm focus:outline-none focus:border-blue-600 focus:shadow-[4px_4px_0px_0px_#005ac2] transition-shadow resize-none placeholder-slate-400"
                    style="min-height: 48px; max-height: 200px; overflow-y: auto;"
                    @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                ></textarea>
            </div>
            <button type="submit"
                :disabled="loading || !input.trim()"
                class="px-5 py-3 bg-blue-600 text-white border-2 border-slate-900 pixel-shadow btn-hover transition-transform font-technical-xs text-technical-xs disabled:opacity-50 disabled:cursor-not-allowed disabled:translate-x-0 disabled:translate-y-0 disabled:shadow-[4px_4px_0px_0px_#1E293B] flex items-center gap-2 self-end">
                <span class="material-symbols-outlined text-[20px]" x-text="loading ? 'hourglass_top' : 'send'">send</span>
            </button>
        </form>
        <p class="font-technical-xs text-technical-xs text-slate-400 mt-2">Shift+Enter for new line · AI has memory of past conversations</p>
    </div>

</div>

<script>
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

            // Reset textarea height
            const ta = this.$refs.msgInput;
            if (ta) { ta.style.height = 'auto'; }

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
                this.dynamicMessages.push({ id: ++this.msgCount, role: 'assistant', content: data.message.content });
                this.scrollToBottom();
            } catch (e) {
                this.dynamicMessages.push({ id: ++this.msgCount, role: 'assistant', content: 'Something went wrong. Please try again.' });
            } finally {
                this.loading = false;
                this.scrollToBottom();
            }
        }
    }
}
</script>

</x-app-layout>
