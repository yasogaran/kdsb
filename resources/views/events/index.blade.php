@extends('layouts.public')

@section('title', 'Events')
@section('description', 'Discover upcoming scouting events, training camps, and activities in Kandy District.')

@section('content')

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-amber-900 to-emerald-900 py-20">
        <div class="container mx-auto px-4">
            <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-4">Upcoming Events</h1>
            <p class="text-xl text-white/90 max-w-2xl">Join us for exciting adventures and learning opportunities</p>
        </div>
    </section>

    <!-- Filters -->
    <section class="py-8 bg-white shadow-sm sticky top-20 z-40">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap gap-4 items-center justify-between">
                <div class="flex gap-2">
                    <a href="{{ route('events.index') }}" class="px-4 py-2 rounded-md {{ !request('filter') || request('filter') == 'upcoming' ? 'bg-amber-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Upcoming
                    </a>
                    <a href="{{ route('events.index', ['filter' => 'past']) }}" class="px-4 py-2 rounded-md {{ request('filter') == 'past' ? 'bg-amber-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        Past Events
                    </a>
                </div>
                <div class="flex gap-2">
                    @foreach(['physical', 'virtual', 'hybrid'] as $type)
                        <a href="{{ route('events.index', ['location_type' => $type] + request()->except('location_type')) }}"
                           class="px-4 py-2 rounded-md text-sm {{ request('location_type') == $type ? 'bg-emerald-900 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                            {{ ucfirst($type) }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Events Grid -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            @if($events->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($events as $event)
                        <x-event-card :event="$event" />
                    @endforeach
                </div>
                <div class="mt-12">
                    {{ $events->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-slate-500 text-lg">No events found. Check back soon!</p>
                </div>
            @endif
        </div>
    </section>
@endsection
