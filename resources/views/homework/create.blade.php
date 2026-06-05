<x-app-layout>

    <header class="flex items-center gap-4 mb-10">
        <a href="{{ route('homework.index') }}" class="w-9 h-9 border-2 border-slate-900 flex items-center justify-center hover:bg-surface-container transition-colors">
            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
        </a>
        <div>
            <h2 class="font-headline-xl text-headline-xl text-slate-900" style="font-family: Epilogue, sans-serif;">Generate Homework</h2>
            <p class="font-technical-sm text-technical-sm text-slate-500 mt-1">Upload your lesson PDF and describe what you need</p>
        </div>
    </header>

    <div class="max-w-2xl" x-data="{ dragging: false, fileName: null, fileSize: null }">

        <form method="POST" action="{{ route('homework.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- PDF Upload -->
            <div class="bg-white border-2 border-slate-900 pixel-shadow">
                <div class="h-1.5 bg-yellow-400 border-b-2 border-slate-900"></div>
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 border-2 border-slate-900 bg-yellow-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-yellow-700">upload_file</span>
                        </div>
                        <div>
                            <h3 class="font-headline-md text-headline-md text-slate-900" style="font-family: Epilogue, sans-serif; font-size: 18px;">Lesson PDF</h3>
                            <p class="font-technical-xs text-technical-xs text-slate-500">Upload the lesson material (max 20MB)</p>
                        </div>
                    </div>

                    <label
                        :class="dragging ? 'border-blue-600 bg-blue-50 shadow-[4px_4px_0px_0px_#005ac2]' : 'border-slate-900 bg-surface-container-low hover:bg-surface-container'"
                        class="border-4 border-dashed cursor-pointer flex flex-col items-center justify-center py-12 transition-all relative"
                        @dragover.prevent="dragging = true"
                        @dragleave="dragging = false"
                        @drop.prevent="dragging = false; const f = $event.dataTransfer.files[0]; if(f){ fileName = f.name; fileSize = (f.size/1024/1024).toFixed(2); $refs.fileInput.files = $event.dataTransfer.files; }"
                        for="pdf">
                        <span class="material-symbols-outlined text-4xl text-slate-400 mb-3" x-text="fileName ? 'check_circle' : 'upload_file'">upload_file</span>
                        <p class="font-technical-sm text-technical-sm text-slate-700 font-bold" x-text="fileName ?? 'Drop PDF here or click to browse'"></p>
                        <p class="font-technical-xs text-technical-xs text-slate-400 mt-1" x-show="fileSize" x-text="fileSize + ' MB'"></p>
                        <p class="font-technical-xs text-technical-xs text-slate-400 mt-1" x-show="!fileName">PDF files only</p>
                        <input type="file" id="pdf" name="pdf" accept=".pdf" x-ref="fileInput" class="hidden"
                               @change="const f = $event.target.files[0]; if(f){ fileName = f.name; fileSize = (f.size/1024/1024).toFixed(2); }">
                    </label>
                    @error('pdf')
                        <p class="mt-2 font-technical-xs text-technical-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Instructions -->
            <div class="bg-white border-2 border-slate-900 pixel-shadow">
                <div class="h-1.5 bg-blue-500 border-b-2 border-slate-900"></div>
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 border-2 border-slate-900 bg-blue-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-blue-700">edit_note</span>
                        </div>
                        <div>
                            <h3 class="font-headline-md text-headline-md text-slate-900" style="font-family: Epilogue, sans-serif; font-size: 18px;">Homework Instructions</h3>
                            <p class="font-technical-xs text-technical-xs text-slate-500">Tell the AI what kind of homework to create</p>
                        </div>
                    </div>

                    <textarea
                        id="instructions"
                        name="instructions"
                        rows="6"
                        placeholder="e.g. Create 10 multiple-choice questions about the main concepts, with an answer key. Include 3 short-answer questions and one essay prompt. Make it suitable for grade 9 students."
                        class="w-full px-4 py-3 bg-surface-container-low border-2 border-slate-900 font-body-md text-body-md text-sm focus:outline-none focus:border-blue-600 focus:shadow-[4px_4px_0px_0px_#005ac2] transition-shadow resize-none placeholder-slate-400"
                    >{{ old('instructions') }}</textarea>
                    @error('instructions')
                        <p class="mt-2 font-technical-xs text-technical-xs text-red-600">{{ $message }}</p>
                    @enderror

                    <!-- Quick prompt chips -->
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach([
                            '10 multiple-choice questions with answer key',
                            '5 short-answer questions',
                            'Fill-in-the-blank worksheet',
                            'True/False quiz (15 questions)',
                            'Essay prompt with rubric',
                        ] as $chip)
                            <button type="button"
                                onclick="document.getElementById('instructions').value += (document.getElementById('instructions').value ? ' ' : '') + '{{ $chip }}.'"
                                class="px-3 py-1.5 border-2 border-slate-900 bg-surface-container font-technical-xs text-technical-xs text-slate-700 hover:bg-surface-container-high transition-colors">
                                + {{ $chip }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center gap-4">
                <button type="submit"
                    class="flex items-center gap-2 px-8 py-4 bg-blue-600 text-white border-2 border-slate-900 pixel-shadow-lg btn-hover transition-transform font-technical-sm text-technical-sm uppercase tracking-wider font-bold">
                    <span class="material-symbols-outlined">auto_awesome</span>
                    Generate Homework
                </button>
                <a href="{{ route('homework.index') }}" class="font-technical-sm text-technical-sm text-slate-500 hover:text-slate-700">Cancel</a>
            </div>

        </form>

    </div>

</x-app-layout>
