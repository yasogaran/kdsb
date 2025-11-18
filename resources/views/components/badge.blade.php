@props(['type' => 'default'])

@php
$classes = match($type) {
    'success' => 'bg-emerald-100 text-emerald-800',
    'warning' => 'bg-amber-100 text-amber-800',
    'error' => 'bg-red-100 text-red-800',
    'info' => 'bg-slate-100 text-slate-800',
    default => 'bg-slate-100 text-slate-800',
};
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold $classes"]) }}>
    {{ $slot }}
</span>
