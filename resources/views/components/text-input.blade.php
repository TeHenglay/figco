@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full px-4 py-3 border-2 border-slate-900 bg-white focus:outline-none focus:border-primary focus:shadow-[4px_4px_0px_0px_#005ac2] transition-shadow placeholder-slate-300']) }}
    style="font-family: Inter, sans-serif; border-radius: 0;">
