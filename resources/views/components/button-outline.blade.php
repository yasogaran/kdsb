@props(['href' => null, 'type' => 'button'])

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-8 py-3 bg-transparent border-2 border-amber-900 text-amber-900 font-semibold rounded-md hover:bg-amber-900 hover:text-white transition-all duration-300']) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-8 py-3 bg-transparent border-2 border-amber-900 text-amber-900 font-semibold rounded-md hover:bg-amber-900 hover:text-white transition-all duration-300']) }}>
        {{ $slot }}
    </button>
@endif
