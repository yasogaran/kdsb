@extends('layouts.public')

@section('title', 'Vision & Mission')
@section('description', 'Learn about the vision, mission, and values that drive Kandy District Scout Branch.')

@section('content')

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-amber-900 to-emerald-900 py-20">
        <div class="container mx-auto px-4">
            <nav class="text-sm text-white/80 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('about.index') }}" class="hover:text-white">About</a>
                <span class="mx-2">/</span>
                <span class="text-white">Vision & Mission</span>
            </nav>

            <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-4">
                Vision & Mission
            </h1>
            <p class="text-xl text-white/90 max-w-2xl">
                Our purpose and commitment to youth development
            </p>
        </div>
    </section>

    <!-- Vision & Mission Content -->
    <section class="py-20">
        <div class="container mx-auto px-4 max-w-5xl">
            <div class="space-y-12">
                <!-- Vision -->
                <div class="bg-amber-50 rounded-2xl p-8 md:p-12 border-2 border-amber-900">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 bg-amber-900 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-slate-900">Our Vision</h2>
                    </div>
                    <p class="text-xl text-slate-700 leading-relaxed">
                        To be the leading youth development organization in Central Sri Lanka, nurturing confident, capable, and compassionate leaders who contribute positively to society.
                    </p>
                </div>

                <!-- Mission -->
                <div class="bg-emerald-50 rounded-2xl p-8 md:p-12 border-2 border-emerald-900">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 bg-emerald-900 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-slate-900">Our Mission</h2>
                    </div>
                    <p class="text-xl text-slate-700 leading-relaxed">
                        To provide quality scouting programs that develop character, foster leadership, promote outdoor skills, and instill values of service, teamwork, and personal responsibility in young people.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Scout Promise and Law -->
    <section class="py-20 bg-slate-50">
        <div class="container mx-auto px-4 max-w-5xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Scout Promise -->
                <x-card>
                    <h3 class="text-2xl font-bold text-slate-900 mb-6">Scout Promise</h3>
                    <div class="prose text-slate-700">
                        <p class="italic">On my honour, I promise that I will do my best:</p>
                        <ul class="space-y-2 mt-4">
                            <li>To do my duty to God and my country</li>
                            <li>To help other people at all times</li>
                            <li>To obey the Scout Law</li>
                        </ul>
                    </div>
                </x-card>

                <!-- Scout Law -->
                <x-card>
                    <h3 class="text-2xl font-bold text-slate-900 mb-6">Scout Law</h3>
                    <div class="prose text-slate-700">
                        <ol class="space-y-2">
                            <li>A Scout's honour is to be trusted</li>
                            <li>A Scout is loyal</li>
                            <li>A Scout's duty is to be useful and help others</li>
                            <li>A Scout is a friend to all</li>
                            <li>A Scout is courteous</li>
                            <li>A Scout is a friend to animals</li>
                            <li>A Scout obeys orders</li>
                            <li>A Scout smiles and whistles under all difficulties</li>
                            <li>A Scout is thrifty</li>
                            <li>A Scout is clean in thought, word and deed</li>
                        </ol>
                    </div>
                </x-card>
            </div>
        </div>
    </section>
@endsection
