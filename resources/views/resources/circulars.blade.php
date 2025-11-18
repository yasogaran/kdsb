@extends('layouts.public')

@section('title', 'Official Circulars')

@section('description')
Access important announcements and official documents from Kandy District Scout Branch. Download circulars, notices, and official communications.
@endsection

@section('content')

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-amber-900 to-emerald-900 py-20">
        <div class="container mx-auto px-4">
            <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-4">Official Circulars</h1>
            <p class="text-xl text-white/90 max-w-2xl">Important announcements and documents</p>
        </div>
    </section>

    <!-- Filters -->
    <section class="py-8 bg-white shadow-sm">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap gap-4">
                <select class="px-4 py-2 border border-slate-300 rounded-md" onchange="window.location.href='?year=' + this.value">
                    <option value="">All Years</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>

                @if($categories->count() > 0)
                    <select class="px-4 py-2 border border-slate-300 rounded-md" onchange="window.location.href='?category=' + this.value">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>
    </section>

    <!-- Circulars Cards -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            @if($circulars->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($circulars as $circular)
                        <x-card :hover="true" class="flex flex-col h-full">
                            <div class="flex-1">
                                <!-- Header -->
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        @if($circular->is_pinned)
                                            <x-badge type="warning" class="mb-2">
                                                <svg class="w-3 h-3 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"/>
                                                </svg>
                                                Pinned
                                            </x-badge>
                                        @endif
                                        @if($circular->category)
                                            <x-badge type="primary" class="mb-2">{{ $circular->category }}</x-badge>
                                        @endif
                                    </div>
                                    <div class="text-right ml-4">
                                        <p class="text-xs text-slate-500">{{ $circular->published_date ? $circular->published_date->format('M d, Y') : 'N/A' }}</p>
                                    </div>
                                </div>

                                <!-- Circular Number -->
                                @if($circular->circular_number)
                                    <p class="text-sm font-semibold text-amber-900 mb-2">{{ $circular->circular_number }}</p>
                                @endif

                                <!-- Title -->
                                <h3 class="text-lg font-bold text-slate-900 mb-3 line-clamp-2">{{ $circular->title }}</h3>

                                <!-- Description -->
                                @if($circular->description)
                                    <p class="text-sm text-slate-600 mb-4 line-clamp-3">{{ $circular->description }}</p>
                                @endif
                            </div>

                            <!-- Action -->
                            <div class="mt-4 pt-4 border-t border-slate-200">
                                @if($circular->file_path)
                                    <a href="{{ Storage::url($circular->file_path) }}" target="_blank" class="inline-flex items-center text-amber-900 hover:text-amber-800 font-semibold">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Download PDF
                                    </a>
                                @elseif($circular->external_link)
                                    <a href="{{ $circular->external_link }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-amber-900 hover:text-amber-800 font-semibold">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                        View Document
                                    </a>
                                @else
                                    <span class="text-sm text-slate-400">No file available</span>
                                @endif
                            </div>
                        </x-card>
                    @endforeach
                </div>
                <div class="mt-12">
                    {{ $circulars->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-slate-500 text-lg">No circulars found.</p>
                    @if(request('year') || request('category'))
                        <a href="{{ route('resources.circulars') }}" class="text-amber-900 hover:text-amber-800 font-semibold mt-2 inline-block">Clear filters</a>
                    @endif
                </div>
            @endif
        </div>
    </section>

    @push('structured-data')
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "CollectionPage",
      "name": "Official Circulars - Kandy District Scout Branch",
      "description": "Official circulars and documents from Kandy District Scout Branch",
      "url": "{{ route('resources.circulars') }}",
      "publisher": {
        "@type": "Organization",
        "name": "Kandy District Scout Branch",
        "url": "{{ url('/') }}"
      }
    }
    </script>
    @endpush
@endsection
