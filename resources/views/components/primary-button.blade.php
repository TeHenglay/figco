<button {{ $attributes->merge(['type' => 'submit', 'class' => 'border-2 border-slate-900 bg-primary text-on-primary px-6 py-3 font-bold shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-none transition-all duration-75 inline-flex items-center gap-2 uppercase tracking-wider']) }}
    style="font-family: \'Space Grotesk\', sans-serif; font-size: 12px; border-radius: 0;">
    {{ $slot }}
</button>
