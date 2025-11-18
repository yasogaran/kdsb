@props(['label' => '', 'description' => ''])

<div class="text-center mb-12">
    @if($label)
        <p class="text-amber-900 font-semibold text-sm uppercase tracking-wide mb-2">{{ $label }}</p>
    @endif
    <h2 class="text-4xl font-bold text-slate-900 mb-4">{{ $slot }}</h2>
    @if($description)
        <p class="text-lg text-slate-600 max-w-3xl mx-auto">{{ $description }}</p>
    @endif
</div>
