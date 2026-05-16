<div class="flex flex-col gap-4">
    <p class="font-body-md text-body-md text-on-surface-variant">
        Once deleted, all your projects, components, and data are <strong class="text-error">permanently gone</strong>. Download anything you want to keep first.
    </p>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="border-2 border-error bg-white text-error px-6 py-3 font-technical-sm text-technical-sm font-bold shadow-[4px_4px_0px_0px_rgba(186,26,26,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all duration-75 sketch-border inline-flex items-center gap-2 w-fit">
        <span class="material-symbols-outlined text-[18px]">delete_forever</span>
        Delete My Account
    </button>
</div>

<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('profile.destroy') }}" class="p-8 flex flex-col gap-5">
        @csrf @method('delete')

        <div class="flex items-center gap-3 border-b-2 border-dashed border-red-200 pb-5">
            <div class="w-12 h-12 border-2 border-error bg-error-container flex items-center justify-center flex-shrink-0 pixel-border">
                <span class="material-symbols-outlined text-on-error-container">warning</span>
            </div>
            <div>
                <h2 class="font-headline-md text-headline-md text-error" style="font-family: Epilogue, sans-serif;">Delete Account?</h2>
                <p class="font-body-md text-body-md text-on-surface-variant text-sm">This action cannot be undone.</p>
            </div>
        </div>

        <p class="font-body-md text-body-md text-on-surface-variant">
            All projects and components will be permanently deleted. Enter your password to confirm.
        </p>

        <div class="flex flex-col gap-2">
            <label for="delete_password" class="font-technical-sm text-technical-sm text-slate-900 uppercase tracking-wider font-bold" style="font-family: 'Space Grotesk', sans-serif;">Password</label>
            <input id="delete_password" name="password" type="password" placeholder="Enter your password"
                   class="w-full px-4 py-3 border-2 border-error bg-white font-body-md focus:outline-none focus:shadow-[4px_4px_0px_0px_rgba(186,26,26,1)] transition-shadow placeholder-slate-300"
                   style="font-family: Inter, sans-serif; border-radius: 0;" />
            @if ($errors->userDeletion->get('password'))
                <p class="font-technical-xs text-technical-xs text-error flex items-center gap-1" style="font-family: 'Space Grotesk', sans-serif;"><span class="material-symbols-outlined text-[14px]">error</span> {{ $errors->userDeletion->first('password') }}</p>
            @endif
        </div>

        <div class="flex items-center justify-end gap-3 pt-2 border-t-2 border-dashed border-red-200">
            <button type="button" x-on:click="$dispatch('close')"
                    class="border-2 border-slate-900 bg-white px-6 py-3 font-technical-xs text-technical-xs font-bold hover:bg-surface-container transition-colors sketch-border">
                Cancel
            </button>
            <button type="submit"
                    class="border-2 border-error bg-error text-white px-6 py-3 font-technical-xs text-technical-xs font-bold shadow-[4px_4px_0px_0px_rgba(186,26,26,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all duration-75 sketch-border inline-flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px]">delete_forever</span>
                Yes, Delete Account
            </button>
        </div>
    </form>
</x-modal>
