@props(['href' => null, 'type' => 'button'])

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-8 py-3 bg-amber-900 text-white font-semibold rounded-md hover:bg-amber-800 hover:-translate-y-0.5 hover:shadow-lg active:translate-y-0 active:shadow-md transition-all duration-300']) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-8 py-3 bg-amber-900 text-white font-semibold rounded-md hover:bg-amber-800 hover:-translate-y-0.5 hover:shadow-lg active:translate-y-0 active:shadow-md transition-all duration-300']) }}>
        {{ $slot }}
    </button>
@endif
