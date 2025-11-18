@extends('layouts.public')

@section('title', 'Photo Gallery')
@section('description', 'Explore memorable moments from our scouting activities and events.')

@section('content')

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-amber-900 to-emerald-900 py-20">
        <div class="container mx-auto px-4">
            <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-4">Photo Gallery</h1>
            <p class="text-xl text-white/90 max-w-2xl">Moments from our scouting journey</p>
        </div>
    </section>

    <!-- Galleries Grid -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            @if($galleries->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($galleries as $gallery)
                        <a href="{{ route('gallery.show', $gallery->slug) }}" class="group relative aspect-[4/3] rounded-lg overflow-hidden">
                            @if($gallery->images->count() > 0)
                                <img src="{{ Storage::url($gallery->images->first()->image_path) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-amber-900 to-emerald-900"></div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-end p-4">
                                <h3 class="text-white font-semibold text-lg mb-1">{{ $gallery->title }}</h3>
                                <p class="text-white/90 text-sm">{{ $gallery->images_count }} photos</p>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-12">
                    {{ $galleries->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-slate-500 text-lg">No galleries available yet.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
