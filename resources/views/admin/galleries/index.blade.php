@extends('admin.layouts.app')

@section('title', 'Galleries')
@section('page-title', 'Gallery Management')

@section('breadcrumbs')
    <span>Content Management / Galleries</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header with Action Button -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Manage photo galleries and albums</p>
        </div>
        @can('create galleries')
        <a href="{{ route('admin.galleries.create') }}"
           class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create New Gallery
        </a>
        @endcan
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4">
        <form method="GET" action="{{ route('admin.galleries.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
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

            <!-- Event Filter -->
            <div>
                <label for="event" class="block text-sm font-medium text-gray-700 mb-1">Event</label>
                <select name="event"
                        id="event"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">All Events</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}" {{ request('event') == $event->id ? 'selected' : '' }}>
                            {{ $event->title }}
                        </option>
                    @endforeach
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

            <!-- Visibility Filter -->
            <div>
                <label for="visibility" class="block text-sm font-medium text-gray-700 mb-1">Visibility</label>
                <select name="visibility"
                        id="visibility"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">All</option>
                    <option value="public" {{ request('visibility') == 'public' ? 'selected' : '' }}>Public</option>
                    <option value="private" {{ request('visibility') == 'private' ? 'selected' : '' }}>Private</option>
                </select>
            </div>

            <!-- Filter Buttons -->
            <div class="md:col-span-4 flex items-center space-x-2">
                <button type="submit"
                        class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
                    Apply Filters
                </button>
                <a href="{{ route('admin.galleries.index') }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Galleries Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($galleries as $gallery)
        <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
            @if($gallery->cover_image)
            <div class="h-48 overflow-hidden bg-gray-200">
                <img src="{{ asset('storage/' . $gallery->cover_image) }}"
                     alt="{{ $gallery->title }}"
                     class="w-full h-full object-cover">
            </div>
            @else
            <div class="h-48 bg-gray-200 flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            @endif

            <div class="p-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center text-xs text-gray-600">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $gallery->image_count ?? 0 }} images
                    </div>

                    <!-- Status Badge -->
                    @if($gallery->status === 'published')
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                        Published
                    </span>
                    @else
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                        Draft
                    </span>
                    @endif
                </div>

                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $gallery->title }}</h3>

                @if($gallery->event)
                <div class="flex items-center text-sm text-gray-600 mb-3">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ Str::limit($gallery->event->title, 30) }}
                </div>
                @endif

                @if($gallery->description)
                <p class="text-sm text-gray-600 line-clamp-2 mb-4">{{ $gallery->description }}</p>
                @endif

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-2 pt-4 border-t border-gray-200">
                    @can('view galleries')
                    <a href="{{ route('admin.galleries.show', $gallery) }}"
                       class="text-gray-600 hover:text-gray-900 text-sm font-medium">
                        View
                    </a>
                    @endcan

                    @can('edit galleries')
                    <a href="{{ route('admin.galleries.edit', $gallery) }}"
                       class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                        Edit
                    </a>
                    @endcan

                    @can('delete galleries')
                    <form action="{{ route('admin.galleries.destroy', $gallery) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this gallery?');"
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-lg font-medium text-gray-900">No galleries found</p>
                <p class="text-sm text-gray-500 mt-1">
                    @if(request()->hasAny(['search', 'event', 'status', 'visibility']))
                        Try adjusting your filters
                    @else
                        Start by creating your first gallery
                    @endif
                </p>
                @if(!request()->hasAny(['search', 'event', 'status', 'visibility']))
                @can('create galleries')
                <a href="{{ route('admin.galleries.create') }}"
                   class="inline-block mt-4 px-4 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
                    Create Gallery
                </a>
                @endcan
                @endif
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($galleries->hasPages())
    <div class="bg-white rounded-lg shadow p-4">
        {{ $galleries->links() }}
    </div>
    @endif
</div>
@endsection
