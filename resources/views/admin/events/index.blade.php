@extends('admin.layouts.app')

@section('title', 'Events')
@section('page-title', 'Events Management')

@section('breadcrumbs')
    <span>Content Management / Events</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header with Action Button -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Manage upcoming and past events</p>
        </div>
        @can('create events')
        <a href="{{ route('admin.events.create') }}"
           class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create New Event
        </a>
        @endcan
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4">
        <form method="GET" action="{{ route('admin.events.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text"
                       name="search"
                       id="search"
                       value="{{ request('search') }}"
                       placeholder="Search by title..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>

            <!-- Period Filter -->
            <div>
                <label for="period" class="block text-sm font-medium text-gray-700 mb-1">Time Period</label>
                <select name="period"
                        id="period"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">All Events</option>
                    <option value="upcoming" {{ request('period') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="past" {{ request('period') == 'past' ? 'selected' : '' }}>Past</option>
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status"
                        id="status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

            <!-- Location Type Filter -->
            <div>
                <label for="location_type" class="block text-sm font-medium text-gray-700 mb-1">Location Type</label>
                <select name="location_type"
                        id="location_type"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">All Types</option>
                    <option value="physical" {{ request('location_type') == 'physical' ? 'selected' : '' }}>Physical</option>
                    <option value="virtual" {{ request('location_type') == 'virtual' ? 'selected' : '' }}>Virtual</option>
                    <option value="hybrid" {{ request('location_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                </select>
            </div>

            <!-- Filter Buttons -->
            <div class="md:col-span-4 flex items-center space-x-2">
                <button type="submit"
                        class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
                    Apply Filters
                </button>
                <a href="{{ route('admin.events.index') }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Events Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
        <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
            @if($event->thumbnail_image)
            <div class="h-48 overflow-hidden bg-gray-200">
                <img src="{{ asset('storage/' . $event->thumbnail_image) }}"
                     alt="{{ $event->title }}"
                     class="w-full h-full object-cover">
            </div>
            @else
            <div class="h-48 bg-gray-200 flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            @endif

            <div class="p-6">
                <div class="flex items-center justify-between mb-3">
                    <!-- Date Badge -->
                    <div class="flex items-center text-xs text-gray-600">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $event->start_datetime->format('M d, Y') }}
                    </div>

                    <!-- Status Badge -->
                    @if($event->status === 'published')
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                        Published
                    </span>
                    @else
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                        Draft
                    </span>
                    @endif
                </div>

                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $event->title }}</h3>

                <div class="space-y-2 mb-4">
                    <!-- Time -->
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $event->start_datetime->format('h:i A') }} - {{ $event->end_datetime->format('h:i A') }}
                    </div>

                    <!-- Location Type -->
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="capitalize">{{ $event->location_type }}</span>
                        @if($event->location_type === 'physical' || $event->location_type === 'hybrid')
                            @if($event->venue_name)
                                - {{ Str::limit($event->venue_name, 20) }}
                            @endif
                        @endif
                    </div>
                </div>

                <p class="text-sm text-gray-600 line-clamp-2 mb-4">{{ $event->summary }}</p>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-2 pt-4 border-t border-gray-200">
                    @can('edit events')
                    <a href="{{ route('admin.events.edit', $event) }}"
                       class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                        Edit
                    </a>
                    @endcan

                    @can('delete events')
                    <form action="{{ route('admin.events.destroy', $event) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this event?');"
                          class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                            Delete
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-lg font-medium text-gray-900">No events found</p>
                <p class="text-sm text-gray-500 mt-1">
                    @if(request()->hasAny(['search', 'period', 'status', 'location_type']))
                        Try adjusting your filters
                    @else
                        Start by creating your first event
                    @endif
                </p>
                @if(!request()->hasAny(['search', 'period', 'status', 'location_type']))
                @can('create events')
                <a href="{{ route('admin.events.create') }}"
                   class="inline-block mt-4 px-4 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
                    Create Event
                </a>
                @endcan
                @endif
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($events->hasPages())
    <div class="bg-white rounded-lg shadow p-4">
        {{ $events->links() }}
    </div>
    @endif
</div>
@endsection
