<form method="post" action="{{ route('password.update') }}" class="flex flex-col gap-5">
    @csrf @method('put')

    <div class="flex flex-col gap-2">
        <label for="update_password_current_password" class="font-technical-sm text-technical-sm text-slate-900 uppercase tracking-wider font-bold" style="font-family: 'Space Grotesk', sans-serif;">Current Password</label>
        <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
               class="w-full px-4 py-3 border-2 border-slate-900 bg-white font-body-md focus:outline-none focus:border-surface-tint focus:shadow-[4px_4px_0px_0px_#005ac2] transition-shadow"
               style="font-family: Inter, sans-serif; border-radius: 0;" />
        @if ($errors->updatePassword->get('current_password'))
            <p class="font-technical-xs text-technical-xs text-error flex items-center gap-1" style="font-family: 'Space Grotesk', sans-serif;"><span class="material-symbols-outlined text-[14px]">error</span> {{ $errors->updatePassword->first('current_password') }}</p>
        @endif
    </div>

    <div class="flex flex-col gap-2">
        <label for="update_password_password" class="font-technical-sm text-technical-sm text-slate-900 uppercase tracking-wider font-bold" style="font-family: 'Space Grotesk', sans-serif;">New Password</label>
        <input id="update_password_password" name="password" type="password" autocomplete="new-password"
               class="w-full px-4 py-3 border-2 border-slate-900 bg-white font-body-md focus:outline-none focus:border-surface-tint focus:shadow-[4px_4px_0px_0px_#005ac2] transition-shadow"
               style="font-family: Inter, sans-serif; border-radius: 0;" />
        @if ($errors->updatePassword->get('password'))
            <p class="font-technical-xs text-technical-xs text-error flex items-center gap-1" style="font-family: 'Space Grotesk', sans-serif;"><span class="material-symbols-outlined text-[14px]">error</span> {{ $errors->updatePassword->first('password') }}</p>
        @endif
    </div>

    <div class="flex flex-col gap-2">
        <label for="update_password_password_confirmation" class="font-technical-sm text-technical-sm text-slate-900 uppercase tracking-wider font-bold" style="font-family: 'Space Grotesk', sans-serif;">Confirm Password</label>
        <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
               class="w-full px-4 py-3 border-2 border-slate-900 bg-white font-body-md focus:outline-none focus:border-surface-tint focus:shadow-[4px_4px_0px_0px_#005ac2] transition-shadow"
               style="font-family: Inter, sans-serif; border-radius: 0;" />
        @if ($errors->updatePassword->get('password_confirmation'))
            <p class="font-technical-xs text-technical-xs text-error flex items-center gap-1" style="font-family: 'Space Grotesk', sans-serif;"><span class="material-symbols-outlined text-[14px]">error</span> {{ $errors->updatePassword->first('password_confirmation') }}</p>
        @endif
    </div>

    <div class="flex items-center gap-4 pt-2 border-t-2 border-dashed border-outline-variant mt-2">
        <button type="submit"
                class="border-2 border-slate-900 bg-surface-tint text-white px-8 py-3 font-technical-sm text-technical-sm font-bold shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all duration-75 sketch-border inline-flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">lock_reset</span>
            Update Password
        </button>
        @if (session('status') === 'password-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
               class="font-technical-xs text-technical-xs text-green-700 flex items-center gap-1" style="font-family: 'Space Grotesk', sans-serif;">
                <span class="material-symbols-outlined text-[14px]">check_circle</span> Updated!
            </p>
        @endif
    </div>
</form>
