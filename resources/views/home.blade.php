@extends('layouts.public')

@section('title', 'Home')
@section('description', 'Kandy District Scout Branch - Building tomorrow's leaders through adventure, service, and character development since 1912.')

@section('content')

    <!-- Hero Section -->
    <section class="relative h-[90vh] min-h-[600px] flex items-center justify-center overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            @if(!empty($settings['hero_image']))
                <img src="{{ Storage::url($settings['hero_image']) }}" alt="Hero Background" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-br from-amber-900 via-emerald-900 to-slate-900"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 to-black/60"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 container mx-auto px-4 text-center text-white">
            <h1 class="text-6xl md:text-7xl font-black mb-6 leading-tight" data-aos="fade-up">
                Building Tomorrow's Leaders Today
            </h1>
            <p class="text-xl md:text-2xl text-slate-100 mb-8 max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="100">
                Empowering youth through adventure, service, and character development since 1912
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center" data-aos="fade-up" data-aos-delay="200">
                <x-button-primary href="{{ route('sections.index') }}" class="text-lg">
                    Join Scouting
                </x-button-primary>
                <x-button-outline href="{{ route('events.index') }}" class="text-lg border-white text-white hover:bg-white hover:text-amber-900">
                    Upcoming Events
                </x-button-outline>
            </div>
        </div>

        <!-- Scroll Down Indicator -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 animate-bounce">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </section>

    <!-- Key Statistics Bar -->
    <section class="bg-amber-900 py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center text-white">
                <div>
                    <div class="text-4xl font-bold mb-1">{{ number_format($stats['active_scouts']) }}+</div>
                    <div class="text-sm opacity-90">Active Scouts</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-1">{{ $stats['scout_groups'] }}+</div>
                    <div class="text-sm opacity-90">Scout Groups</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-1">{{ $stats['years_service'] }}+</div>
                    <div class="text-sm opacity-90">Years of Service</div>
                </div>
                <div>
                    <div class="text-4xl font-bold mb-1">{{ $stats['annual_events'] }}+</div>
                    <div class="text-sm opacity-90">Annual Events</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Events Section -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <p class="text-amber-900 font-semibold text-sm uppercase tracking-wide mb-2">Upcoming Activities</p>
                    <h2 class="text-4xl font-bold text-slate-900">Join Our Next Adventure</h2>
                </div>
                <a href="{{ route('events.index') }}" class="text-amber-900 font-semibold hover:text-amber-800 transition hidden md:flex items-center">
                    See All Events
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            @if($events->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($events as $event)
                        <x-event-card :event="$event" />
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-slate-500">No upcoming events at the moment. Check back soon!</p>
                </div>
            @endif

            <div class="text-center mt-8 md:hidden">
                <a href="{{ route('events.index') }}" class="inline-flex items-center text-amber-900 font-semibold">
                    See All Events
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Latest News Section -->
    <section class="py-20 bg-slate-50">
        <div class="container mx-auto px-4">
            <x-section-title label="News & Updates" description="Stay informed about our latest achievements and announcements">
                Latest from Kandy Scouts
            </x-section-title>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Featured Post -->
                @if($featuredPost)
                    <div class="lg:col-span-2">
                        <x-post-card :post="$featuredPost" :featured="true" />
                    </div>
                @endif

                <!-- Recent Posts -->
                <div class="space-y-4">
                    <h3 class="text-xl font-bold text-slate-900 mb-4">Recent Posts</h3>
                    @forelse($recentPosts as $post)
                        <x-post-card :post="$post" />
                    @empty
                        <p class="text-slate-500 text-sm">No recent posts available.</p>
                    @endforelse
                </div>
            </div>

            <div class="text-center mt-12">
                <x-button-primary href="{{ route('news.index') }}">
                    View All News
                </x-button-primary>
            </div>
        </div>
    </section>

    <!-- Scout Sections Showcase -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <x-section-title label="Our Sections" description="Discover the right scouting section for your age group">
                Scouting for Every Age
            </x-section-title>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @php
                $sections = [
                    ['name' => 'Singithi', 'age' => 'Ages 3-5', 'slug' => 'singithi'],
                    ['name' => 'Cubs', 'age' => 'Ages 6-10', 'slug' => 'cubs'],
                    ['name' => 'Scouts', 'age' => 'Ages 11-15', 'slug' => 'scouts'],
                    ['name' => 'Senior Scouts', 'age' => 'Ages 16-18', 'slug' => 'senior-scouts'],
                    ['name' => 'Rovers', 'age' => 'Ages 18-25', 'slug' => 'rovers'],
                    ['name' => 'Masters', 'age' => 'Adult Leaders', 'slug' => 'masters'],
                ];
                @endphp

                @foreach($sections as $section)
                    <a href="{{ route('sections.show', $section['slug']) }}" class="text-center group">
                        <div class="w-32 h-32 mx-auto mb-4 rounded-full bg-gradient-to-br from-amber-900 to-emerald-900 overflow-hidden group-hover:scale-110 transition-transform duration-300">
                            <!-- Placeholder for section image -->
                            <div class="w-full h-full flex items-center justify-center text-white text-4xl font-bold">
                                {{ substr($section['name'], 0, 1) }}
                            </div>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900 group-hover:text-emerald-900 transition">
                            {{ $section['name'] }}
                        </h3>
                        <p class="text-sm text-slate-600">{{ $section['age'] }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Commissioner's Message -->
    @if(!empty($settings['commissioner_message']))
        <section class="py-20 bg-slate-50">
            <div class="container mx-auto px-4">
                <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-lg p-8 md:p-12">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @if(!empty($settings['commissioner_photo']))
                            <div class="md:col-span-1">
                                <img src="{{ Storage::url($settings['commissioner_photo']) }}" alt="District Commissioner" class="w-full rounded-xl shadow-md">
                            </div>
                        @endif

                        <div class="md:col-span-2">
                            <p class="text-amber-900 font-semibold text-sm uppercase tracking-wide mb-2">A Message from Our</p>
                            <h2 class="text-3xl font-bold text-slate-900 mb-4">District Commissioner</h2>

                            @if(!empty($settings['commissioner_name']))
                                <div class="mb-6">
                                    <p class="text-lg font-semibold text-slate-900">{{ $settings['commissioner_name'] }}</p>
                                    <p class="text-sm text-slate-600">District Commissioner</p>
                                </div>
                            @endif

                            <div class="prose prose-lg max-w-none text-slate-700">
                                {!! nl2br(e($settings['commissioner_message'])) !!}
                            </div>

                            @if(!empty($settings['commissioner_signature']))
                                <div class="mt-6">
                                    <img src="{{ Storage::url($settings['commissioner_signature']) }}" alt="Signature" class="h-16">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Gallery Highlight -->
    @if($galleries->count() > 0)
        <section class="py-20">
            <div class="container mx-auto px-4">
                <x-section-title label="Our Journey" description="Explore memorable moments from our scouting activities">
                    Moments from Our Journey
                </x-section-title>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    @foreach($galleries as $gallery)
                        @if($gallery->images->count() > 0)
                            @php $image = $gallery->images->first(); @endphp
                            <a href="{{ route('gallery.show', $gallery->slug) }}" class="aspect-square rounded-lg overflow-hidden group relative">
                                <img src="{{ Storage::url($image->image_path) }}" alt="{{ $image->caption ?? $gallery->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-4">
                                    <div class="text-white">
                                        <p class="font-semibold text-sm">{{ $gallery->title }}</p>
                                        <p class="text-xs opacity-90">{{ $gallery->images->count() }} photos</p>
                                    </div>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>

                <div class="text-center">
                    <x-button-primary href="{{ route('gallery.index') }}">
                        View Full Gallery
                    </x-button-primary>
                </div>
            </div>
        </section>
    @endif

    <!-- Call-to-Action Banner -->
    <section class="bg-emerald-900 py-16">
        <div class="container mx-auto px-4 text-center text-white">
            <h2 class="text-4xl md:text-5xl font-bold mb-4">Ready to Start Your Adventure?</h2>
            <p class="text-lg md:text-xl text-emerald-50 mb-8 max-w-2xl mx-auto">
                Join thousands of scouts building skills for life
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <x-button-primary href="{{ route('sections.index') }}" class="bg-amber-900 hover:bg-amber-800">
                    Join Now
                </x-button-primary>
                <x-button-outline href="{{ route('about.index') }}" class="border-white text-white hover:bg-white hover:text-emerald-900">
                    Learn More
                </x-button-outline>
            </div>
        </div>
    </section>
@endsection
