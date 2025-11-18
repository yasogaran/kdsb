@extends('layouts.public')

@section('title', '{{ $post->title }}')
@section('description', '{{ $post->meta_description ?? $post->excerpt ?? Str::limit(strip_tags($post->content), 160) }}')

@section('content')
@section('ogImage', '{{ $post->featured_image ? Storage::url($post->featured_image) : null }}')

    <!-- Featured Image -->
    @if($post->featured_image)
        <section class="relative h-[600px]">
            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
        </section>
    @endif

    <!-- Content -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Category Badge -->
                @if($post->category)
                    <x-badge type="success" class="mb-4">{{ $post->category->name }}</x-badge>
                @endif

                <!-- Title -->
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-6">{{ $post->title }}</h1>

                <!-- Meta Info -->
                <div class="flex items-center text-slate-600 mb-8 pb-8 border-b">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $post->published_at->format('F d, Y') }}
                    <span class="mx-2">|</span>
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read
                </div>

                <!-- Content -->
                <div class="prose prose-lg max-w-none">
                    {!! $post->content !!}
                </div>

                <!-- Tags -->
                @if($post->tags)
                    <div class="mt-12 pt-8 border-t">
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $post->tags) as $tag)
                                <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-full text-sm">#{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Sidebar with Recent Posts & Categories -->
    <section class="py-12 bg-slate-50">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Recent Posts -->
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-6">Recent Posts</h3>
                    <div class="space-y-4">
                        @foreach($recentPosts as $recent)
                            <x-post-card :post="$recent" />
                        @endforeach
                    </div>
                </div>

                <!-- Categories -->
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-6">Categories</h3>
                    <div class="space-y-2">
                        @foreach($categories as $category)
                            <a href="{{ route('news.index', ['category' => $category->slug]) }}" class="block px-4 py-3 bg-white rounded-lg hover:bg-amber-50 hover:border-amber-900 border transition">
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold text-slate-900">{{ $category->name }}</span>
                                    <span class="text-sm text-slate-500">{{ $category->posts_count }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
