@extends('layouts.public')

@section('title', 'About Us')
@section('description', 'Learn about Kandy District Scout Branch - our history, mission, and commitment to developing tomorrow\'s leaders.')

@section('content')

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-amber-900 to-emerald-900 py-20">
        <div class="container mx-auto px-4">
            <nav class="text-sm text-white/80 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <span class="mx-2">/</span>
                <span class="text-white">About Us</span>
            </nav>

            <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-4">
                About Kandy District Scout Branch
            </h1>
            <p class="text-xl text-white/90 max-w-2xl">
                Serving the community since 1912
            </p>
        </div>
    </section>

    <!-- Overview Section -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <h2 class="text-3xl font-bold text-slate-900 mb-6">Our Story</h2>
                    <div class="prose prose-lg max-w-none text-slate-700 space-y-4">
                        <p>
                            The Kandy District Scout Branch has been at the forefront of youth development in Central Sri Lanka for over a century. Founded in 1912, we have continuously evolved while maintaining our core values of character development, citizenship training, and personal fitness.
                        </p>
                        <p>
                            Our organization serves as a pillar of the scouting movement in Sri Lanka, providing thousands of young people with opportunities to develop leadership skills, engage in outdoor activities, and contribute to their communities through service.
                        </p>
                        <p>
                            Today, we proudly support over 180 scout groups across the Kandy District, reaching more than 15,000 active scouts from diverse backgrounds. Our programs cater to all age groups, from the youngest Singithi members to adult Scout Masters, ensuring that everyone has the opportunity to experience the transformative power of scouting.
                        </p>
                        <p>
                            Through camping, hiking, community service, and skill-building activities, we prepare young people to face the challenges of the modern world with confidence, competence, and compassion.
                        </p>
                    </div>
                </div>

                <!-- Key Facts Box -->
                <div>
                    <div class="bg-amber-50 border-2 border-amber-900 rounded-xl p-6 sticky top-24">
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Key Facts</h3>
                        <ul class="space-y-3 text-slate-700">
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-emerald-900 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span><strong>Established:</strong> 1912</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-emerald-900 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span><strong>Scout Groups:</strong> 180+</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-emerald-900 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span><strong>Active Scouts:</strong> 15,000+</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-emerald-900 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span><strong>Annual Events:</strong> 500+</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-6 h-6 text-emerald-900 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span><strong>Age Range:</strong> 3-25+ years</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission -->
    <section class="py-20 bg-slate-50">
        <div class="container mx-auto px-4">
            <x-section-title label="Our Purpose">
                Vision & Mission
            </x-section-title>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
                <!-- Vision Card -->
                <x-card class="text-center">
                    <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-amber-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Our Vision</h3>
                    <p class="text-slate-600">
                        To be the leading youth development organization in Central Sri Lanka, nurturing confident, capable, and compassionate leaders who contribute positively to society.
                    </p>
                </x-card>

                <!-- Mission Card -->
                <x-card class="text-center">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-emerald-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Our Mission</h3>
                    <p class="text-slate-600">
                        To provide quality scouting programs that develop character, foster leadership, promote outdoor skills, and instill values of service, teamwork, and personal responsibility in young people.
                    </p>
                </x-card>
            </div>
        </div>
    </section>

    <!-- Our Values -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <x-section-title label="What We Stand For">
                Our Core Values
            </x-section-title>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
                @php
                $values = [
                    ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Integrity', 'description' => 'We uphold honesty, trustworthiness, and moral principles in all our actions.'],
                    ['icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'title' => 'Leadership', 'description' => 'We develop leaders who inspire others and make positive change.'],
                    ['icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'title' => 'Service', 'description' => 'We dedicate ourselves to helping others and serving our community.'],
                    ['icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'Adventure', 'description' => 'We embrace challenges and explore the great outdoors with enthusiasm.'],
                    ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'title' => 'Teamwork', 'description' => 'We work together, respecting and supporting each other to achieve common goals.'],
                    ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'title' => 'Learning', 'description' => 'We commit to continuous personal development and skill building.'],
                ];
                @endphp

                @foreach($values as $value)
                    <x-card>
                        <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-amber-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $value['icon'] }}"/>
                            </svg>
                        </div>
                        <h4 class="text-xl font-semibold text-slate-900 mb-2">{{ $value['title'] }}</h4>
                        <p class="text-slate-600 text-sm">{{ $value['description'] }}</p>
                    </x-card>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Quick Links to Other Pages -->
    <section class="py-20 bg-slate-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <a href="{{ route('about.history') }}" class="group">
                    <x-card>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-amber-900 to-emerald-900 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-amber-900 transition">Our History</h3>
                            <p class="text-slate-600 text-sm mb-4">Explore our journey from 1912 to today</p>
                            <span class="text-amber-900 font-semibold text-sm flex items-center justify-center">
                                Learn More
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </div>
                    </x-card>
                </a>

                <a href="{{ route('about.team') }}" class="group">
                    <x-card>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-amber-900 to-emerald-900 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-amber-900 transition">Leadership Team</h3>
                            <p class="text-slate-600 text-sm mb-4">Meet the people who lead our organization</p>
                            <span class="text-amber-900 font-semibold text-sm flex items-center justify-center">
                                Meet the Team
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </div>
                    </x-card>
                </a>

                <a href="{{ route('sections.index') }}" class="group">
                    <x-card>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-amber-900 to-emerald-900 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-amber-900 transition">Scout Sections</h3>
                            <p class="text-slate-600 text-sm mb-4">Discover scouting opportunities for all ages</p>
                            <span class="text-amber-900 font-semibold text-sm flex items-center justify-center">
                                Explore Sections
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </div>
                    </x-card>
                </a>
            </div>
        </div>
    </section>
@endsection
