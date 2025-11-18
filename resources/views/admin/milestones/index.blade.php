@extends('admin.layouts.app')

@section('title', 'Milestones')
@section('page-title', 'History Milestones')

@section('breadcrumbs')
    <span>Site Management / Milestones</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header with Action Button -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Manage organization history timeline</p>
        </div>
        @can('create milestones')
        <a href="{{ route('admin.milestones.create') }}"
           class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Milestone
        </a>
        @endcan
    </div>

    <!-- Milestones Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($milestones as $milestone)
        <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
            @if($milestone->image)
            <div class="h-48 overflow-hidden bg-gray-200">
                <img src="{{ asset('storage/' . $milestone->image) }}"
                     alt="{{ $milestone->title }}"
                     class="w-full h-full object-cover">
            </div>
            @else
            <div class="h-48 bg-gray-200 flex items-center justify-center">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            @endif

            <div class="p-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="inline-block px-3 py-1 text-sm font-semibold bg-primary text-white rounded-full">
                        {{ $milestone->year }}
                    </span>
                    <span class="text-xs text-gray-500">Order: {{ $milestone->display_order }}</span>
                </div>

                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $milestone->title }}</h3>
                <p class="text-sm text-gray-600 line-clamp-3">{{ $milestone->description }}</p>

                <!-- Actions -->
                <div class="flex items-center justify-end space-x-2 mt-4 pt-4 border-t border-gray-200">
                    @can('edit milestones')
                    <a href="{{ route('admin.milestones.edit', $milestone) }}"
                       class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                        Edit
                    </a>
                    @endcan

                    @can('delete milestones')
                    <form action="{{ route('admin.milestones.destroy', $milestone) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this milestone?');"
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-lg font-medium text-gray-900">No milestones found</p>
                <p class="text-sm text-gray-500 mt-1">Start building your organization's history timeline</p>
                @can('create milestones')
                <a href="{{ route('admin.milestones.create') }}"
                   class="inline-block mt-4 px-4 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
                    Create Milestone
                </a>
                @endcan
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($milestones->hasPages())
    <div class="bg-white rounded-lg shadow p-4">
        {{ $milestones->links() }}
    </div>
    @endif
</div>
@endsection
