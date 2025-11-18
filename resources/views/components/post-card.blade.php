@props(['post', 'featured' => false])

@if($featured)
    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
        @if($post->featured_image)
            <div class="aspect-video overflow-hidden">
                <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        <div class="p-6">
            @if($post->category)
                <x-badge type="success" class="mb-3">{{ $post->category->name }}</x-badge>
            @endif

            <h3 class="text-3xl font-bold text-slate-900 mb-3">{{ $post->title }}</h3>

            @if($post->excerpt)
                <p class="text-slate-600 mb-4 line-clamp-3">{{ $post->excerpt }}</p>
            @endif

            <div class="flex items-center text-sm text-slate-500 mb-4">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ $post->published_at->format('F d, Y') }}
            </div>

            <a href="{{ route('news.show', $post->slug) }}" class="inline-flex items-center text-amber-900 font-semibold hover:text-amber-800 transition">
                Read More
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
@else
    <div class="flex gap-4 hover:bg-slate-50 p-4 rounded-lg transition">
        @if($post->featured_image)
            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-24 h-24 object-cover rounded">
        @else
            <div class="w-24 h-24 bg-gradient-to-br from-amber-900 to-emerald-900 rounded"></div>
        @endif

        <div class="flex-1">
            <h4 class="font-semibold text-slate-900 mb-2 hover:text-amber-900 transition">
                <a href="{{ route('news.show', $post->slug) }}">{{ $post->title }}</a>
            </h4>
            <p class="text-sm text-slate-500">{{ $post->published_at->format('F d, Y') }}</p>
        </div>
    </div>
@endif
