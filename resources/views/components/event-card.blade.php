@props(['event'])

<div class="bg-white border border-slate-200 rounded-lg overflow-hidden shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
    @if($event->thumbnail_image)
        <div class="aspect-video overflow-hidden">
            <img src="{{ Storage::url($event->thumbnail_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
        </div>
    @elseif($event->banner_image)
        <div class="aspect-video overflow-hidden">
            <img src="{{ Storage::url($event->banner_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
        </div>
    @else
        <div class="aspect-video bg-gradient-to-br from-amber-900 to-emerald-900"></div>
    @endif

    <div class="p-6">
        <div class="mb-3">
            <x-badge type="warning">{{ $event->start_datetime->format('M d, Y') }}</x-badge>
        </div>

        <h3 class="text-xl font-semibold text-slate-900 mb-3">{{ $event->title }}</h3>

        <div class="space-y-2 text-sm text-slate-600 mb-4">
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ $event->venue_name ?? $event->address ?? 'Kandy' }}
            </div>
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ ucfirst($event->location_type) }}
            </div>
        </div>

        @if($event->summary)
            <p class="text-sm text-slate-600 mb-4 line-clamp-2">{{ $event->summary }}</p>
        @endif

        @if($event->registration_deadline && $event->registration_deadline->isFuture())
            <p class="text-xs text-amber-900 font-medium mb-4">
                Register by: {{ $event->registration_deadline->format('M d, Y') }}
            </p>
        @endif

        <a href="{{ route('events.show', $event->slug) }}" class="inline-flex items-center text-amber-900 font-semibold hover:text-amber-800 transition">
            Learn More
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</div>
