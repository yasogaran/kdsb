@extends('layouts.public')

@section('title', 'Scout Sections')
@section('description', 'Explore scouting opportunities for all ages - from Singithi to Scout Masters.')

@section('content')

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-amber-900 to-emerald-900 py-20">
        <div class="container mx-auto px-4">
            <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-4">Scout Sections</h1>
            <p class="text-xl text-white/90 max-w-2xl">Scouting for every age and stage of development</p>
        </div>
    </section>

    <!-- Sections Grid -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($sections as $slug => $section)
                    <a href="{{ route('sections.show', $slug) }}" class="group">
                        <x-card>
                            <div class="w-32 h-32 mx-auto mb-6 rounded-full bg-gradient-to-br from-amber-900 to-emerald-900 flex items-center justify-center text-white text-4xl font-bold group-hover:scale-110 transition-transform">
                                {{ substr($section['name'], 0, 1) }}
                            </div>
                            <h3 class="text-2xl font-bold text-slate-900 text-center mb-2 group-hover:text-amber-900 transition">
                                {{ $section['name'] }}
                            </h3>
                            <p class="text-center text-slate-600 mb-4">{{ $section['age_range'] }}</p>
                            <p class="text-sm text-slate-600 text-center">{{ $section['description'] }}</p>
                        </x-card>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection
