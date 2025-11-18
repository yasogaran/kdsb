<x-layouts.public>
    <x-slot name="title">News & Updates</x-slot>
    <x-slot name="description">Stay informed about the latest news, achievements, and announcements from Kandy District Scout Branch.</x-slot>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-amber-900 to-emerald-900 py-20">
        <div class="container mx-auto px-4">
            <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-4">News & Updates</h1>
            <p class="text-xl text-white/90 max-w-2xl">Latest stories from our scouting community</p>
        </div>
    </section>

    <!-- Filters -->
    <section class="py-8 bg-white shadow-sm sticky top-20 z-40">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('news.index') }}" class="px-4 py-2 rounded-md {{ !request('category') ? 'bg-amber-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    All Posts
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('news.index', ['category' => $category->slug]) }}" class="px-4 py-2 rounded-md {{ request('category') == $category->slug ? 'bg-amber-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        {{ $category->name }} ({{ $category->posts_count }})
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Posts Grid -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            @if($posts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($posts as $post)
                        <div class="bg-white border border-slate-200 rounded-lg overflow-hidden shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                            @if($post->featured_image)
                                <div class="aspect-video overflow-hidden">
                                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                </div>
                            @endif
                            <div class="p-6">
                                @if($post->category)
                                    <x-badge type="success" class="mb-3">{{ $post->category->name }}</x-badge>
                                @endif
                                <h3 class="text-xl font-semibold text-slate-900 mb-3">
                                    <a href="{{ route('news.show', $post->slug) }}" class="hover:text-amber-900">{{ $post->title }}</a>
                                </h3>
                                @if($post->excerpt)
                                    <p class="text-sm text-slate-600 mb-4 line-clamp-3">{{ $post->excerpt }}</p>
                                @endif
                                <div class="flex items-center text-xs text-slate-500 mb-4">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $post->published_at->format('F d, Y') }}
                                </div>
                                <a href="{{ route('news.show', $post->slug) }}" class="inline-flex items-center text-amber-900 font-semibold hover:text-amber-800">
                                    Read More
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-12">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-slate-500 text-lg">No posts found.</p>
                </div>
            @endif
        </div>
    </section>
</x-layouts.public>
