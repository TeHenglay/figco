@props(['value'])

<label {{ $attributes->merge(['class' => 'font-bold uppercase tracking-wider text-slate-900']) }}
    style="font-family: \'Space Grotesk\', sans-serif; font-size: 12px;">
    {{ $value ?? $slot }}
</label>
