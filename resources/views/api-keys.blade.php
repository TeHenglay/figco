<x-app-layout>

    <!-- Header -->
    <header class="flex justify-between items-center mb-10">
        <div>
            <h2 class="font-headline-xl text-headline-xl text-slate-900" style="font-family: Epilogue, sans-serif;">API Keys</h2>
            <p class="font-technical-sm text-technical-sm text-slate-500 mt-1">Manage your integration credentials</p>
        </div>
        <div class="flex items-center gap-2 px-3 py-2 border-2 border-slate-900 bg-surface-container-low font-technical-xs text-technical-xs text-slate-700">
            <span class="w-2 h-2 bg-{{ $user->figma_access_token ? 'green' : 'red' }}-500 border border-slate-900 block"></span>
            {{ $user->figma_access_token ? 'Figma Connected' : 'Figma Not Connected' }}
        </div>
    </header>

    @if(session('status') === 'api-keys-updated')
        <div class="mb-6 flex items-center gap-3 px-4 py-3 bg-green-100 border-2 border-green-600 font-technical-sm text-technical-sm text-green-800">
            <span class="material-symbols-outlined text-[18px]">check_circle</span>
            API keys updated successfully.
        </div>
    @endif

    <!-- Figma Token Card -->
    <div class="bg-white border-2 border-slate-900 pixel-shadow mb-8">
        <!-- Top accent -->
        <div class="h-1.5 bg-blue-500 border-b-2 border-slate-900"></div>

        <div class="p-8">
            <div class="flex items-start gap-4 mb-6">
                <div class="w-12 h-12 border-2 border-slate-900 bg-blue-100 flex items-center justify-center flex-shrink-0 pixel-border">
                    <span class="material-symbols-outlined text-blue-700">design_services</span>
                </div>
                <div>
                    <h3 class="font-headline-md text-headline-md text-slate-900 mb-1" style="font-family: Epilogue, sans-serif;">Figma Personal Access Token</h3>
                    <p class="font-body-md text-body-md text-slate-500 text-sm">Required to fetch component data from your Figma files. Generate one from Figma → Account Settings → Personal Access Tokens.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('api-keys.update') }}">
                @csrf

                <div class="mb-6">
                    <x-input-label for="figma_access_token" value="Figma Access Token" />
                    <div class="relative mt-2">
                        <x-text-input
                            id="figma_access_token"
                            name="figma_access_token"
                            type="password"
                            class="w-full pr-12"
                            value="{{ $user->figma_access_token ? str_repeat('•', 32) : '' }}"
                            placeholder="figd_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
                            autocomplete="off"
                        />
                        <button type="button"
                            onclick="this.previousElementSibling.type = this.previousElementSibling.type === 'password' ? 'text' : 'password'"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700">
                            <span class="material-symbols-outlined text-[20px]">visibility</span>
                        </button>
                    </div>
                    @error('figma_access_token')
                        <p class="mt-2 font-technical-xs text-technical-xs text-red-600">{{ $message }}</p>
                    @enderror

                    @if($user->figma_access_token)
                        <div class="mt-3 flex items-center gap-2 px-3 py-2 bg-green-50 border-2 border-green-500 font-technical-xs text-technical-xs text-green-700">
                            <span class="material-symbols-outlined text-[16px]">verified</span>
                            Token is saved. Enter a new one to replace it.
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Save Token
                    </x-primary-button>

                    @if($user->figma_access_token)
                        <button type="submit" name="clear_figma_token" value="1"
                            class="border-2 border-red-600 text-red-700 px-5 py-3 font-technical-xs text-technical-xs uppercase tracking-wider font-bold hover:bg-red-50 transition-colors inline-flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                            Remove Token
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Info Card: How to get a Figma token -->
    <div class="bg-surface-container-low border-2 border-slate-900 p-6">
        <h4 class="font-technical-sm text-technical-sm text-slate-700 uppercase tracking-wider mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px] text-blue-600">info</span>
            How to get your Figma token
        </h4>
        <ol class="space-y-3">
            @foreach([
                'Open Figma and click your profile avatar in the top-left corner.',
                'Go to Settings → Account → Personal access tokens.',
                'Click "Add new token" and give it a description.',
                'Copy the token immediately — it will only be shown once.',
                'Paste it above and click Save Token.',
            ] as $i => $step)
                <li class="flex items-start gap-3 font-technical-xs text-technical-xs text-slate-600">
                    <span class="w-6 h-6 border-2 border-slate-900 bg-white flex items-center justify-center flex-shrink-0 font-bold text-slate-900">{{ $i + 1 }}</span>
                    {{ $step }}
                </li>
            @endforeach
        </ol>
    </div>

</x-app-layout>
