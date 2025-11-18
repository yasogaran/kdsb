@extends('layouts.public')

@section('title', 'Our History')
@section('description', 'Discover the rich history of Kandy District Scout Branch from 1912 to today.')

@section('content')

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-amber-900 to-emerald-900 py-20">
        <div class="container mx-auto px-4">
            <nav class="text-sm text-white/80 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('about.index') }}" class="hover:text-white">About</a>
                <span class="mx-2">/</span>
                <span class="text-white">History</span>
            </nav>

            <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-4">
                Our History
            </h1>
            <p class="text-xl text-white/90 max-w-2xl">
                Over a century of building leaders and serving the community
            </p>
        </div>
    </section>

    <!-- Timeline -->
    <section class="py-20">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="space-y-12">
                @forelse($milestones as $milestone)
                    <div class="flex gap-8">
                        <!-- Year -->
                        <div class="flex-shrink-0 w-24 pt-1">
                            <div class="text-3xl font-bold text-amber-900">{{ $milestone->year }}</div>
                        </div>

                        <!-- Timeline Line -->
                        <div class="flex-shrink-0 flex flex-col items-center">
                            <div class="w-4 h-4 rounded-full bg-emerald-900 border-4 border-white shadow"></div>
                            @if(!$loop->last)
                                <div class="w-0.5 h-full bg-amber-900/30 mt-2"></div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="flex-1 pb-12">
                            <x-card :hover="false">
                                @if($milestone->image)
                                    <img src="{{ Storage::url($milestone->image) }}" alt="{{ $milestone->title }}" class="w-full h-48 object-cover rounded-lg mb-4">
                                @endif
                                <h3 class="text-2xl font-bold text-slate-900 mb-3">{{ $milestone->title }}</h3>
                                <div class="prose max-w-none text-slate-700">
                                    {!! nl2br(e($milestone->description)) !!}
                                </div>
                            </x-card>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <p class="text-slate-500">Timeline coming soon. Check back later for our historical milestones.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
