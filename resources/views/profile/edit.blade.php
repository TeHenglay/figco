<x-app-layout>

    <!-- Header -->
    <header class="flex items-center gap-4 mb-10">
        <div class="w-14 h-14 border-4 border-slate-900 bg-primary-fixed flex items-center justify-center sketch-border shadow-[6px_6px_0px_0px_rgba(30,41,59,1)]">
            <span class="material-symbols-outlined text-[32px] text-on-primary-fixed" style="font-variation-settings: 'FILL' 1;">manage_accounts</span>
        </div>
        <div>
            <h2 class="font-headline-xl text-headline-xl text-slate-900" style="font-family: Epilogue, sans-serif;">Settings</h2>
            <p class="font-technical-sm text-technical-sm text-slate-500 uppercase tracking-wider mt-1" style="font-family: 'Space Grotesk', sans-serif;">{{ Auth::user()->email }}</p>
        </div>
    </header>

    <div class="max-w-2xl flex flex-col gap-6">

        <!-- Profile Information -->
        <div class="bg-white border-2 border-slate-900 shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] sketch-border overflow-hidden">
            <div class="h-2 bg-primary"></div>
            <div class="px-8 py-6 border-b-2 border-dashed border-slate-200">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary text-[22px]">person</span>
                    <h3 class="font-headline-md text-headline-md text-on-background" style="font-family: Epilogue, sans-serif;">Profile Information</h3>
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant mt-1">Update your name, email, and Figma access token.</p>
            </div>
            <div class="p-8">
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

                <form method="post" action="{{ route('profile.update') }}" class="flex flex-col gap-5">
                    @csrf @method('patch')

                    <!-- Name -->
                    <div class="flex flex-col gap-2">
                        <label for="name" class="font-technical-sm text-technical-sm text-slate-900 uppercase tracking-wider font-bold" style="font-family: 'Space Grotesk', sans-serif;">Name</label>
                        <input id="name" name="name" type="text"
                               value="{{ old('name', $user->name) }}"
                               required autofocus autocomplete="name"
                               class="w-full px-4 py-3 border-2 border-slate-900 bg-white font-body-md focus:outline-none focus:border-primary focus:shadow-[4px_4px_0px_0px_#005ac2] transition-shadow"
                               style="font-family: Inter, sans-serif; border-radius: 0;" />
                        @error('name')
                            <p class="font-technical-xs text-technical-xs text-error flex items-center gap-1" style="font-family: 'Space Grotesk', sans-serif;"><span class="material-symbols-outlined text-[14px]">error</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="flex flex-col gap-2">
                        <label for="email" class="font-technical-sm text-technical-sm text-slate-900 uppercase tracking-wider font-bold" style="font-family: 'Space Grotesk', sans-serif;">Email</label>
                        <input id="email" name="email" type="email"
                               value="{{ old('email', $user->email) }}"
                               required autocomplete="username"
                               class="w-full px-4 py-3 border-2 border-slate-900 bg-white font-body-md focus:outline-none focus:border-primary focus:shadow-[4px_4px_0px_0px_#005ac2] transition-shadow"
                               style="font-family: Inter, sans-serif; border-radius: 0;" />
                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="flex items-center gap-2 p-3 bg-yellow-50 border-2 border-yellow-500">
                                <span class="material-symbols-outlined text-[16px] text-yellow-700">warning</span>
                                <span class="font-technical-xs text-technical-xs text-yellow-800" style="font-family: 'Space Grotesk', sans-serif;">
                                    Your email is unverified.
                                    <button form="send-verification" class="underline font-bold hover:text-yellow-900">Re-send verification</button>
                                </span>
                            </div>
                            @if (session('status') === 'verification-link-sent')
                                <p class="font-technical-xs text-technical-xs text-green-700 flex items-center gap-1" style="font-family: 'Space Grotesk', sans-serif;"><span class="material-symbols-outlined text-[14px]">check_circle</span> Verification link sent!</p>
                            @endif
                        @endif
                        @error('email')
                            <p class="font-technical-xs text-technical-xs text-error flex items-center gap-1" style="font-family: 'Space Grotesk', sans-serif;"><span class="material-symbols-outlined text-[14px]">error</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Figma Access Token -->
                    <div class="flex flex-col gap-2">
                        <label for="figma_access_token" class="font-technical-sm text-technical-sm text-slate-900 uppercase tracking-wider font-bold" style="font-family: 'Space Grotesk', sans-serif;">
                            Figma Access Token
                            @if($user->figma_access_token)
                                <span class="ml-2 px-2 py-0.5 bg-green-100 border border-green-600 text-green-800 font-technical-xs text-technical-xs normal-case tracking-normal">Connected</span>
                            @endif
                        </label>
                        <input id="figma_access_token" name="figma_access_token" type="password"
                               value="{{ old('figma_access_token', $user->figma_access_token ? str_repeat('•', 24) : '') }}"
                               placeholder="figd_xxxxxxxxxxxxxxxxxxxxx"
                               autocomplete="off"
                               class="w-full px-4 py-3 border-2 border-slate-900 bg-white font-technical-sm focus:outline-none focus:border-primary focus:shadow-[4px_4px_0px_0px_#005ac2] transition-shadow placeholder-slate-300"
                               style="font-family: 'Space Grotesk', sans-serif; font-size: 13px; border-radius: 0;" />
                        <div class="flex items-start gap-2 p-3 bg-surface-container-low border-2 border-outline-variant">
                            <span class="material-symbols-outlined text-[16px] text-outline mt-0.5 flex-shrink-0">info</span>
                            <p class="font-technical-xs text-technical-xs text-on-surface-variant" style="font-family: 'Space Grotesk', sans-serif;">
                                Figma → Account Settings → Personal access tokens. Leave blank to keep the existing token.
                            </p>
                        </div>
                        @error('figma_access_token')
                            <p class="font-technical-xs text-technical-xs text-error flex items-center gap-1" style="font-family: 'Space Grotesk', sans-serif;"><span class="material-symbols-outlined text-[14px]">error</span> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-4 pt-2 border-t-2 border-dashed border-outline-variant mt-2">
                        <button type="submit"
                                class="border-2 border-slate-900 bg-primary text-on-primary px-8 py-3 font-technical-sm text-technical-sm font-bold shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all duration-75 sketch-border inline-flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">save</span>
                            Save Changes
                        </button>
                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                               class="font-technical-xs text-technical-xs text-green-700 flex items-center gap-1" style="font-family: 'Space Grotesk', sans-serif;">
                                <span class="material-symbols-outlined text-[14px]">check_circle</span> Saved!
                            </p>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Update Password -->
        <div class="bg-white border-2 border-slate-900 shadow-[6px_6px_0px_0px_rgba(30,41,59,1)] sketch-border overflow-hidden">
            <div class="h-2 bg-surface-tint"></div>
            <div class="px-8 py-6 border-b-2 border-dashed border-slate-200">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-surface-tint text-[22px]">lock</span>
                    <h3 class="font-headline-md text-headline-md text-on-background" style="font-family: Epilogue, sans-serif;">Update Password</h3>
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant mt-1">Use a long, random password to stay secure.</p>
            </div>
            <div class="p-8">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="bg-white border-2 border-error shadow-[6px_6px_0px_0px_rgba(186,26,26,1)] sketch-border overflow-hidden">
            <div class="h-2 bg-error"></div>
            <div class="px-8 py-6 border-b-2 border-dashed border-red-200">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-error text-[22px]">dangerous</span>
                    <h3 class="font-headline-md text-headline-md text-error" style="font-family: Epilogue, sans-serif;">Danger Zone</h3>
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant mt-1">Permanently delete your account and all data.</p>
            </div>
            <div class="p-8">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>

</x-app-layout>
