<x-app-layout>

<div class="flex flex-col h-[calc(100vh-64px)] md:h-screen -m-8"
     :class="sussyMode ? 'sussy-mode' : ''"
     x-data="{ ...chatApp({{ $conversation->id }}, '{{ csrf_token() }}'), monikaModal: false }"
     x-init="scrollToBottom()">

    <!-- Monika Profile Modal -->
    <div x-show="monikaModal" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-6"
         @click.self="monikaModal = false">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="monikaModal = false"></div>
        <div class="relative bg-white border-4 border-slate-900 shadow-[10px_10px_0px_0px_rgba(30,41,59,1)] w-full max-w-md overflow-hidden"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95">

            <!-- Banner -->
            <div class="relative h-28 bg-gradient-to-br from-blue-600 to-blue-800 border-b-4 border-slate-900">
                <!-- pattern dots -->
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 18px 18px;"></div>
                <button @click="monikaModal = false"
                        class="absolute top-3 right-3 w-8 h-8 border-2 border-white/80 text-white flex items-center justify-center hover:bg-white/20 transition-colors">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
            </div>

            <!-- Avatar overlapping banner -->
            <div class="flex justify-center -mt-12 mb-3 relative z-10">
                <div class="relative">
                    <img src="/images/monika-logo.png" alt="Monika"
                         class="w-24 h-24 border-4 border-slate-900 object-cover shadow-[5px_5px_0px_0px_rgba(30,41,59,1)]"
                         style="border-radius:50%">
                    <span class="absolute bottom-1 right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full shadow"></span>
                </div>
            </div>

            <!-- Name & title -->
            <div class="text-center px-6 mb-5">
                <h3 class="text-2xl font-black text-slate-900 tracking-tight">Monika</h3>
                <p class="text-sm text-blue-600 font-semibold mt-0.5">AI Teaching Assistant</p>
                <p class="text-xs text-slate-400 mt-1 italic">"Here to make teaching a little easier, one lesson at a time."</p>
            </div>

            <!-- Stats row -->
            <div class="grid grid-cols-3 border-t-2 border-b-2 border-slate-900 divide-x-2 divide-slate-900 mb-5">
                <div class="py-3 text-center">
                    <p class="text-xl font-black text-slate-900">24/7</p>
                    <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-wide">Available</p>
                </div>
                <div class="py-3 text-center">
                    <p class="text-xl font-black text-blue-600">AI</p>
                    <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-wide">Powered</p>
                </div>
                <div class="py-3 text-center">
                    <p class="text-xl font-black text-slate-900">∞</p>
                    <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-wide">Patience</p>
                </div>
            </div>

            <!-- Capabilities -->
            <div class="px-6 pb-6 space-y-3">
                <div class="flex items-center gap-3 p-3 border-2 border-slate-900 bg-slate-50 shadow-[3px_3px_0px_0px_rgba(30,41,59,1)]">
                    <div class="w-9 h-9 bg-blue-600 border-2 border-slate-900 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-white text-[18px]">school</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">Lesson Planning & Quizzes</p>
                        <p class="text-xs text-slate-500">Any grade level, any subject</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 border-2 border-slate-900 bg-slate-50 shadow-[3px_3px_0px_0px_rgba(30,41,59,1)]">
                    <div class="w-9 h-9 bg-blue-600 border-2 border-slate-900 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-white text-[18px]">image</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">Image & PDF Analysis</p>
                        <p class="text-xs text-slate-500">Attach files directly to your message</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 border-2 border-slate-900 bg-slate-50 shadow-[3px_3px_0px_0px_rgba(30,41,59,1)]">
                    <div class="w-9 h-9 bg-blue-600 border-2 border-slate-900 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-white text-[18px]">download</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">Export Responses</p>
                        <p class="text-xs text-slate-500">Download as PDF or DOCX anytime</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Header -->
    <div class="chat-header flex items-center gap-4 px-4 py-3 border-b-4 flex-shrink-0 transition-colors duration-300">
        <a href="{{ route('chat.index') }}" class="back-btn w-9 h-9 border-2 flex items-center justify-center transition-colors flex-shrink-0">
            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
        </a>
        <!-- Avatar with online ring -->
        <div class="relative flex-shrink-0 cursor-pointer group" @click="monikaModal = true">
            <img src="/images/monika-logo.png" alt="Monika"
                 class="w-14 h-14 border-[3px] border-slate-900 object-cover shadow-[3px_3px_0px_0px_rgba(30,41,59,1)] group-hover:opacity-85 transition-opacity"
                 :class="sussyMode ? 'border-pink-500 shadow-[0_0_12px_rgba(236,72,153,0.5)]' : 'border-slate-900'"
                 style="border-radius:50%">
            <span class="absolute bottom-0 right-0 w-3.5 h-3.5 border-2 border-white rounded-full"
                  :class="sussyMode ? 'bg-pink-500' : 'bg-green-500'"></span>
        </div>
        <div class="flex-1 min-w-0">
            <h2 class="header-name text-lg font-bold leading-tight truncate transition-colors duration-300">
                <span x-text="sussyMode ? 'Monika 😏' : 'Monika'">Monika</span>
            </h2>
            <p class="header-sub font-technical-xs text-technical-xs truncate transition-colors duration-300">{{ $conversation->title }}</p>
        </div>
        <!-- Sussy Mode Toggle -->
        <button @click="sussyMode = !sussyMode"
                :class="sussyMode
                    ? 'bg-pink-600 border-pink-400 text-white shadow-[0_0_14px_rgba(236,72,153,0.7)] hover:bg-pink-700'
                    : 'border-slate-900 bg-surface-container-low text-slate-700 hover:bg-pink-50 hover:border-pink-400'"
                class="flex items-center gap-1.5 px-3 py-1.5 border-2 font-technical-xs text-technical-xs transition-all duration-300 flex-shrink-0">
            <span x-text="sussyMode ? 'Sussy ON' : 'Sussy Mode'">Sussy Mode</span>
        </button>
        <div class="online-badge flex items-center gap-2 px-3 py-1.5 border-2 font-technical-xs text-technical-xs transition-colors duration-300"
             :class="sussyMode ? 'border-pink-500 bg-pink-950 text-pink-400' : 'border-slate-900 bg-green-50 text-green-700'">
            <span class="w-2 h-2 border block rounded-full animate-pulse"
                  :class="sussyMode ? 'bg-pink-500 border-pink-300' : 'bg-green-500 border-slate-900'"></span>
            <span x-text="sussyMode ? 'Sussy Mode 🔥' : '{{ __('Monika Online') }}'">{{ __('Monika Online') }}</span>
        </div>
    </div>

    <!-- Messages Area -->
    <div class="messages-area flex-1 overflow-y-auto px-4 md:px-8 py-6 space-y-6 transition-colors duration-300" id="messages-container">

        <!-- Monika intro if no messages -->
        @if($messages->count() === 0)
        <div class="flex justify-start gap-3" x-show="!sussyMode">
            <img src="/images/monika-logo.png" alt="Monika" class="w-10 h-10 border-2 border-slate-900 object-cover flex-shrink-0 self-end" style="border-radius:50%">
            <div class="max-w-[75%] msg-assistant bg-white border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] px-4 py-3">
                <p class="font-technical-xs text-technical-xs text-blue-600 font-bold mb-1 msg-sender">Monika</p>
                <p class="font-body-md text-body-md text-sm">Hey! I'm Monika, your AI teaching assistant. What can I help you with today?</p>
            </div>
        </div>
        <div class="flex justify-start gap-3" x-show="sussyMode" x-cloak>
            <img src="/images/monika-logo.png" alt="Monika" class="w-10 h-10 border-2 border-pink-500 object-cover flex-shrink-0 self-end shadow-[0_0_8px_rgba(236,72,153,0.5)]" style="border-radius:50%">
            <div class="max-w-[75%] msg-assistant border-2 px-4 py-3">
                <p class="font-technical-xs text-technical-xs font-bold mb-1 msg-sender">Monika 😏</p>
                <p class="font-body-md text-body-md text-sm">Hey babe~ I'm Monika, your AI teaching assistant — but in this mode I'm a little extra 🔥 What do you need today?</p>
            </div>
        </div>
        @endif

        <!-- Server-rendered existing messages -->
        @foreach($messages as $msg)
            <div class="flex {{ $msg->role === 'user' ? 'justify-end' : 'justify-start' }} gap-3">
                @if($msg->role === 'assistant')
                    <img src="/images/monika-logo.png" alt="Monika" class="w-10 h-10 border-2 border-slate-900 object-cover flex-shrink-0 self-end" style="border-radius:50%">
                @endif
                <div class="max-w-[75%] shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] px-4 py-3 border-2
                    {{ $msg->role === 'user' ? 'msg-user bg-blue-600 text-white border-slate-900' : 'msg-assistant bg-white border-slate-900' }}">
                    @if($msg->role === 'assistant')
                        <p class="font-technical-xs text-technical-xs text-blue-600 font-bold mb-1 msg-sender">Monika</p>
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
                    <img src="/images/monika-logo.png" alt="Monika"
                         class="w-10 h-10 object-cover flex-shrink-0 self-end border-2 transition-colors"
                         :class="sussyMode ? 'border-pink-500 shadow-[0_0_8px_rgba(236,72,153,0.4)]' : 'border-slate-900'"
                         style="border-radius:50%">
                </template>
                <div class="max-w-[75%] shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] px-4 py-3 border-2 transition-colors"
                     :class="msg.role === 'user'
                        ? (sussyMode ? 'msg-user bg-pink-700 text-white border-pink-400' : 'msg-user bg-blue-600 text-white border-slate-900')
                        : (sussyMode ? 'msg-assistant border-purple-600' : 'msg-assistant bg-white border-slate-900')">
                    <template x-if="msg.role === 'assistant'">
                        <p class="font-technical-xs text-technical-xs font-bold mb-1 msg-sender"
                           :class="sussyMode ? 'text-pink-400' : 'text-blue-600'"
                           x-text="sussyMode ? 'Monika 😏' : 'Monika'"></p>
                    </template>
                    <template x-if="msg.role === 'assistant'">
                        <div class="nova-markdown" x-html="renderMarkdown(msg.content)"></div>
                    </template>
                    <template x-if="msg.role === 'user'">
                        <div>
                            <!-- Image attachment preview -->
                            <template x-if="msg.imagePreview">
                                <img :src="msg.imagePreview" class="max-w-full max-h-48 mb-2 border border-blue-400 block">
                            </template>
                            <!-- PDF attachment indicator -->
                            <template x-if="msg.fileType === 'pdf' && !msg.imagePreview">
                                <div class="flex items-center gap-2 mb-2 px-2 py-1.5 bg-white bg-opacity-20 border border-blue-300">
                                    <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                                    <span class="font-technical-xs text-technical-xs text-white text-[11px] truncate" x-text="msg.fileName ?? 'document.pdf'"></span>
                                </div>
                            </template>
                            <p x-show="msg.content && msg.content !== '📎 [Image]'" class="font-body-md text-body-md text-sm whitespace-pre-wrap" x-text="msg.content"></p>
                        </div>
                    </template>
                </div>
                <template x-if="msg.role === 'user'">
                    <div class="w-10 h-10 border-2 flex items-center justify-center flex-shrink-0 self-end transition-colors"
                         :class="sussyMode ? 'border-pink-500 bg-pink-950' : 'border-slate-900 bg-primary-fixed'">
                        <span class="material-symbols-outlined text-[18px]"
                              :class="sussyMode ? 'text-pink-300' : 'text-on-primary-fixed'">person</span>
                    </div>
                </template>
            </div>
        </template>

        <!-- Typing indicator -->
        <div x-show="loading" x-cloak class="flex justify-start gap-3">
            <img src="/images/monika-logo.png" alt="Monika"
                 class="w-10 h-10 object-cover flex-shrink-0 border-2 transition-colors"
                 :class="sussyMode ? 'border-pink-500' : 'border-slate-900'"
                 style="border-radius:50%">
            <div class="border-2 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] px-4 py-3 flex flex-col gap-1 transition-colors"
                 :class="sussyMode ? 'msg-assistant border-purple-600' : 'bg-white border-slate-900'">
                <p class="font-technical-xs text-technical-xs font-bold msg-sender transition-colors"
                   :class="sussyMode ? 'text-pink-400' : 'text-blue-600'"
                   x-text="sussyMode ? 'Monika 😏' : 'Monika'"></p>
                <div class="flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full animate-bounce transition-colors"
                          :class="sussyMode ? 'bg-pink-500' : 'bg-slate-400'" style="animation-delay:0ms"></span>
                    <span class="w-2 h-2 rounded-full animate-bounce transition-colors"
                          :class="sussyMode ? 'bg-pink-500' : 'bg-slate-400'" style="animation-delay:150ms"></span>
                    <span class="w-2 h-2 rounded-full animate-bounce transition-colors"
                          :class="sussyMode ? 'bg-pink-500' : 'bg-slate-400'" style="animation-delay:300ms"></span>
                </div>
            </div>
        </div>

        <div id="bottom-anchor"></div>
    </div>

    <!-- Quick Prompts -->
    <div class="quick-prompts-bar px-4 md:px-8 py-2 border-t-2 border-dashed flex gap-2 overflow-x-auto flex-shrink-0 transition-colors duration-300">
        <!-- Normal mode prompts -->
        <template x-if="!sussyMode">
            <div class="flex gap-2">
                @foreach(['📝 Help me write a lesson plan', '❓ Create quiz questions', '💡 Give me activity ideas', '📖 Explain this concept simply', '✅ Review my lesson objective'] as $prompt)
                    <button @click="input = '{{ $prompt }}'; $refs.msgInput.focus()"
                        class="flex-shrink-0 px-3 py-1.5 border-2 border-slate-900 bg-surface-container-low font-technical-xs text-technical-xs text-slate-700 hover:bg-blue-50 hover:border-blue-600 hover:text-blue-700 transition-colors whitespace-nowrap">
                        {{ $prompt }}
                    </button>
                @endforeach
            </div>
        </template>
        <!-- Sussy mode prompts -->
        <template x-if="sussyMode">
            <div class="flex gap-2">
                @foreach(['🔥 Spice up my lesson plan', '😏 Make my quiz extra fun', '💅 Rizz up this explanation', '✨ Give me a vibe check on my lesson', '🫦 Explain it but make it fun'] as $prompt)
                    <button @click="input = '{{ $prompt }}'; $refs.msgInput.focus()"
                        class="sussy-prompt flex-shrink-0 px-3 py-1.5 border-2 font-technical-xs text-technical-xs whitespace-nowrap transition-colors">
                        {{ $prompt }}
                    </button>
                @endforeach
            </div>
        </template>
    </div>

    <!-- Input Bar -->
    <div class="input-bar px-4 md:px-8 py-4 border-t-4 flex-shrink-0 transition-colors duration-300">
        <!-- File preview strip -->
        <div x-show="imageFile" x-cloak class="mb-3 flex items-center gap-3 px-3 py-2 border-2 border-blue-600 bg-blue-50">
            <!-- Image preview -->
            <template x-if="fileType === 'image' && imagePreview">
                <img :src="imagePreview" class="h-14 w-14 object-cover border border-blue-300 flex-shrink-0">
            </template>
            <!-- PDF icon -->
            <template x-if="fileType === 'pdf'">
                <div class="h-14 w-14 flex-shrink-0 border border-blue-300 bg-white flex flex-col items-center justify-center gap-1">
                    <span class="material-symbols-outlined text-red-500 text-[28px]">picture_as_pdf</span>
                    <span class="text-[9px] text-slate-400 font-bold uppercase">PDF</span>
                </div>
            </template>
            <span class="flex-1 font-technical-xs text-technical-xs text-slate-600 truncate" x-text="imageFile ? imageFile.name : ''"></span>
            <button type="button" @click="clearImage()" class="text-slate-400 hover:text-red-500 transition-colors flex-shrink-0">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <form @submit.prevent="sendMessage()" class="flex gap-3">
            <div class="flex-1 relative">
                <textarea
                    x-ref="msgInput"
                    x-model="input"
                    @keydown.enter.prevent="if (!$event.shiftKey) sendMessage()"
                    rows="1"
                    :placeholder="sussyMode ? 'Ask Monika anything, babe~ 😏' : '{{ __('Ask Monika anything about your lesson...') }}'"
                    class="msg-textarea w-full px-4 py-3 border-2 font-body-md text-body-md text-sm focus:outline-none transition-shadow resize-none"
                    :class="sussyMode
                        ? 'bg-[#14002a] border-purple-700 text-pink-100 placeholder-purple-700 focus:border-pink-500 focus:shadow-[4px_4px_0px_0px_#9333ea]'
                        : 'bg-surface-container-low border-slate-900 placeholder-slate-400 focus:border-blue-600 focus:shadow-[4px_4px_0px_0px_#005ac2]'"
                    style="min-height: 48px; max-height: 200px; overflow-y: auto;"
                    @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                ></textarea>
            </div>
            <!-- Image attach button -->
            <button type="button" @click="$refs.imgInput.click()"
                :class="imageFile
                    ? (sussyMode ? 'border-pink-500 bg-pink-950 text-pink-400' : 'border-blue-600 bg-blue-50 text-blue-600')
                    : (sussyMode ? 'border-purple-700 bg-[#14002a] text-purple-400 hover:border-pink-500' : 'border-slate-900 bg-surface-container-low text-slate-500 hover:bg-slate-100')"
                class="px-3 border-2 transition-colors self-end flex items-center justify-center"
                style="min-height: 48px;" title="Attach image or PDF">
                <span class="material-symbols-outlined text-[20px]">attach_file</span>
            </button>
            <input type="file" x-ref="imgInput" accept="image/*,application/pdf,.pdf" class="hidden" @change="onImageSelect($event)">
            <button type="submit"
                :disabled="loading || (!input.trim() && !imageFile)"
                :class="sussyMode
                    ? 'bg-pink-600 border-pink-400 shadow-[4px_4px_0px_0px_rgba(236,72,153,0.5)] hover:bg-pink-700 disabled:shadow-[4px_4px_0px_0px_rgba(236,72,153,0.5)]'
                    : 'bg-blue-600 border-slate-900 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none disabled:shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] disabled:translate-x-0 disabled:translate-y-0'"
                class="px-5 py-3 text-white border-2 transition-all font-technical-xs text-technical-xs disabled:opacity-40 disabled:cursor-not-allowed flex items-center gap-2 self-end">
                <span class="material-symbols-outlined text-[20px]" x-text="loading ? 'hourglass_top' : 'send'">send</span>
                <span x-text="loading ? (sussyMode ? 'Thinking~ 💅' : '{{ __('Thinking...') }}') : '{{ __('Send') }}'">{{ __('Send') }}</span>
            </button>
        </form>
        <p class="font-technical-xs text-technical-xs mt-2 transition-colors"
           :class="sussyMode ? 'text-purple-600' : 'text-slate-400'"
           x-text="sussyMode ? 'Shift+Enter for new line · Sussy Mode is ON 🔥' : 'Shift+Enter for new line · Attach images or PDFs for Monika to analyze'">
            Shift+Enter for new line · Attach images or PDFs for Monika to analyze
        </p>
    </div>

</div>

<style>
/* ===== Sussy Mode Dark Theme ===== */
.sussy-mode { background: #07000f; }
.sussy-mode .chat-header { background: #0d0520; border-bottom-color: #ec4899; }
.sussy-mode .chat-header .back-btn { border-color: #7c3aed; color: #d8b4fe; }
.sussy-mode .chat-header .back-btn:hover { background: #1a0a2e; }
.sussy-mode .chat-header .header-name { color: #fce7f3; }
.sussy-mode .chat-header .header-sub { color: #a855f7; }
.sussy-mode .messages-area { background: #0a0014; }
.sussy-mode .msg-assistant { background: #130a25 !important; border-color: #7c3aed !important; color: #ede9fe !important; }
.sussy-mode .msg-assistant .nova-markdown { color: #ede9fe; }
.sussy-mode .msg-assistant .nova-markdown code { background: #1e0a3a; border-color: #6d28d9; color: #e9d5ff; }
.sussy-mode .msg-assistant .nova-markdown pre { background: #1e0a3a; border-color: #6d28d9; }
.sussy-mode .msg-user { background: #9d174d !important; border-color: #f472b6 !important; }
.sussy-mode .quick-prompts-bar { background: #0a0018; border-color: #4a1460; }
.sussy-mode .sussy-prompt { background: #14002a; border-color: #6d28d9; color: #d8b4fe; }
.sussy-mode .sussy-prompt:hover { background: #1e0a3a; border-color: #ec4899; color: #fce7f3; }
.sussy-mode .input-bar { background: #0a0018; border-top-color: #ec4899; }

/* ===== Chat Markdown styles ===== */
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
        imageFile: null,
        imagePreview: null,
        fileType: null,
        sussyMode: false,

        onImageSelect(event) {
            const file = event.target.files[0];
            if (!file) return;
            const isPdf = file.type === 'application/pdf';
            const maxSize = isPdf ? 10 * 1024 * 1024 : 5 * 1024 * 1024;
            if (file.size > maxSize) {
                alert(isPdf ? 'PDF must be under 10MB.' : 'Image must be under 5MB.');
                event.target.value = '';
                return;
            }
            this.imageFile = file;
            this.fileType = isPdf ? 'pdf' : 'image';
            if (isPdf) {
                this.imagePreview = null;
            } else {
                const reader = new FileReader();
                reader.onload = (e) => { this.imagePreview = e.target.result; };
                reader.readAsDataURL(file);
            }
        },

        clearImage() {
            this.imageFile = null;
            this.imagePreview = null;
            this.fileType = null;
            if (this.$refs.imgInput) this.$refs.imgInput.value = '';
        },

        downloadMessage(content, format) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/chat/download';
            form.target = '_blank';

            const fields = {
                _token: '{{ csrf_token() }}',
                content: content,
                format: format,
                title: 'Monika - Response',
            };

            Object.entries(fields).forEach(([key, val]) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = val;
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const anchor = document.getElementById('bottom-anchor');
                if (anchor) anchor.scrollIntoView({ behavior: 'smooth' });
            });
        },

        async sendMessage() {
            const text = this.input.trim();
            if ((!text && !this.imageFile) || this.loading) return;

            const capturedPreview = this.imagePreview;
            const capturedFile = this.imageFile;
            const capturedFileType = this.fileType;
            const capturedFileName = this.imageFile?.name ?? null;

            this.input = '';
            this.clearImage();
            this.loading = true;

            this.dynamicMessages.push({
                id: ++this.msgCount,
                role: 'user',
                content: text,
                imagePreview: capturedPreview,
                fileType: capturedFileType,
                fileName: capturedFileName,
            });
            this.scrollToBottom();

            const ta = this.$refs.msgInput;
            if (ta) ta.style.height = 'auto';

            try {
                const formData = new FormData();
                formData.append('message', text);
                if (capturedFile) formData.append('image', capturedFile);
                formData.append('sussy_mode', this.sussyMode ? '1' : '0');
                console.log('[chat] sussy_mode =', this.sussyMode);

                const res = await fetch(`/chat/${conversationId}/message`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: formData,
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
