@extends('layouts.public')

@section('title', $gallery->title)

@section('description')
{{ $gallery->description ?? 'View photos from ' . $gallery->title }}
@endsection

@section('content')

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-amber-900 to-emerald-900 py-20">
        <div class="container mx-auto px-4">
            <nav class="text-sm text-white/80 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('gallery.index') }}" class="hover:text-white">Gallery</a>
                <span class="mx-2">/</span>
                <span class="text-white">{{ $gallery->title }}</span>
            </nav>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4">{{ $gallery->title }}</h1>
            @if($gallery->description)
                <p class="text-lg text-white/90 max-w-3xl">{{ $gallery->description }}</p>
            @endif
            <div class="flex items-center gap-4 mt-6 text-white/80">
                <span>{{ $gallery->images->count() }} Photos</span>
                @if($gallery->event_date)
                    <span>•</span>
                    <span>{{ $gallery->event_date->format('F d, Y') }}</span>
                @endif
            </div>
        </div>
    </section>

    <!-- Photo Grid -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            @if($gallery->images->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" x-data="{ lightbox: null }">
                    @foreach($gallery->images as $image)
                        <div @click="lightbox = {{ $loop->index }}" class="aspect-square rounded-lg overflow-hidden cursor-pointer group">
                            <img src="{{ Storage::url($image->image_path) }}" alt="{{ $image->caption ?? $gallery->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        </div>

                        <!-- Simple Lightbox -->
                        <div x-show="lightbox === {{ $loop->index }}" @click.away="lightbox = null" @keydown.escape.window="lightbox = null" class="fixed inset-0 bg-black/90 z-50 flex items-center justify-center p-4" x-transition>
                            <button @click="lightbox = null" class="absolute top-4 right-4 text-white hover:text-slate-300">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            <img src="{{ Storage::url($image->image_path) }}" alt="{{ $image->caption ?? $gallery->title }}" class="max-w-full max-h-full">
                            @if($image->caption)
                                <div class="absolute bottom-0 inset-x-0 bg-black/50 text-white p-4 text-center">
                                    {{ $image->caption }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-slate-500">This gallery is empty.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
