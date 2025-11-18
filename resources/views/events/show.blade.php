@extends('layouts.public')

@section('title', $event->title)

@section('description')
{{ $event->summary ?? Str::limit(strip_tags($event->content), 160) }}
@endsection

@section('content')

    <!-- Hero Banner -->
    <section class="relative h-[500px]">
        @if($event->banner_image)
            <img src="{{ Storage::url($event->banner_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full bg-gradient-to-br from-amber-900 to-emerald-900"></div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
        @if($event->start_datetime >= now())
            <div class="absolute top-8 right-8">
                <x-badge type="success" class="text-base px-4 py-2">Registration Open</x-badge>
            </div>
        @else
            <div class="absolute top-8 right-8">
                <x-badge class="text-base px-4 py-2">Past Event</x-badge>
            </div>
        @endif
    </section>

    <!-- Event Content -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <h1 class="text-4xl md:text-5xl font-bold text-slate-900 mb-6">{{ $event->title }}</h1>

                    <div class="prose prose-lg max-w-none">
                        {!! $event->content !!}
                    </div>

                    @if($event->galleries->count() > 0)
                        <div class="mt-12">
                            <h3 class="text-2xl font-bold text-slate-900 mb-6">Event Gallery</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                @foreach($event->galleries as $gallery)
                                    @foreach($gallery->images as $image)
                                        <img src="{{ Storage::url($image->image_path) }}" alt="{{ $image->caption }}" class="w-full aspect-square object-cover rounded-lg">
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div>
                    <x-card class="sticky top-24">
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Event Details</h3>
                        <div class="space-y-4">
                            <div>
                                <div class="flex items-center text-slate-600 mb-1">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="font-semibold">Date & Time</span>
                                </div>
                                <p class="text-slate-700 ml-7">
                                    {{ $event->start_datetime->format('F d, Y') }}
                                    @if($event->end_datetime && $event->end_datetime->format('Y-m-d') != $event->start_datetime->format('Y-m-d'))
                                        - {{ $event->end_datetime->format('F d, Y') }}
                                    @endif
                                </p>
                            </div>

                            @if($event->venue_name || $event->address)
                                <div>
                                    <div class="flex items-center text-slate-600 mb-1">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        </svg>
                                        <span class="font-semibold">Location</span>
                                    </div>
                                    <p class="text-slate-700 ml-7">{{ $event->venue_name ?? $event->address }}</p>
                                </div>
                            @endif

                            <div>
                                <div class="flex items-center text-slate-600 mb-1">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945"/>
                                    </svg>
                                    <span class="font-semibold">Type</span>
                                </div>
                                <p class="text-slate-700 ml-7">{{ ucfirst($event->location_type) }}</p>
                            </div>

                            @if($event->registration_deadline && $event->registration_deadline->isFuture())
                                <div class="pt-4 border-t">
                                    <p class="text-sm text-amber-900 font-semibold">
                                        Register by: {{ $event->registration_deadline->format('F d, Y') }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        @if($event->start_datetime >= now())
                            <div class="mt-6">
                                <x-button-primary href="{{ route('contact') }}" class="w-full justify-center">
                                    Register Now
                                </x-button-primary>
                            </div>
                        @endif
                    </x-card>

                    @if($relatedEvents->count() > 0)
                        <div class="mt-8">
                            <h4 class="text-lg font-bold text-slate-900 mb-4">Related Events</h4>
                            <div class="space-y-4">
                                @foreach($relatedEvents as $related)
                                    <a href="{{ route('events.show', $related->slug) }}" class="block group">
                                        <x-card :hover="false" class="group-hover:shadow-md transition">
                                            <h5 class="font-semibold text-slate-900 group-hover:text-amber-900 mb-2">{{ $related->title }}</h5>
                                            <p class="text-sm text-slate-600">{{ $related->start_datetime->format('M d, Y') }}</p>
                                        </x-card>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
