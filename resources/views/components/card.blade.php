@props(['hover' => true])

<div {{ $attributes->merge(['class' => 'bg-white border border-slate-200 rounded-lg p-6 shadow-sm ' . ($hover ? 'hover:shadow-lg hover:-translate-y-1 transition-all duration-300' : '')]) }}>
    {{ $slot }}
</div>
