@extends('admin.layouts.app')

@section('title', 'View Gallery')
@section('page-title', $gallery->title)

@section('breadcrumbs')
    <a href="{{ route('admin.galleries.index') }}" class="text-primary hover:text-amber-800">Galleries</a>
    <span class="mx-2">/</span>
    <span>{{ Str::limit($gallery->title, 30) }}</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Action Buttons -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">View gallery details and images</p>
        </div>
        <div class="flex items-center space-x-2">
            @can('edit galleries')
            <a href="{{ route('admin.galleries.edit', $gallery) }}"
               class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Gallery
            </a>
            @endcan
        </div>
    </div>

    <!-- Gallery Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Cover Image -->
            @if($gallery->cover_image)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Cover Image</h3>
                <img src="{{ asset('storage/' . $gallery->cover_image) }}"
                     alt="{{ $gallery->title }}"
                     class="w-full rounded-lg border border-gray-300">
            </div>
            @endif

            <!-- Gallery Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Gallery Information</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $gallery->title }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Slug</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $gallery->slug }}</p>
                    </div>

                    @if($gallery->description)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $gallery->description }}</p>
                    </div>
                    @endif

                    @if($gallery->event)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Related Event</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $gallery->event->title }}</p>
                    </div>
                    @endif

                    @if($gallery->date_taken)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date Taken</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $gallery->date_taken->format('M d, Y') }}</p>
                    </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Layout Type</label>
                            <p class="mt-1 text-sm text-gray-900 capitalize">{{ $gallery->layout_type }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Visibility</label>
                            <p class="mt-1 text-sm text-gray-900 capitalize">{{ $gallery->visibility }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Image Count</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $gallery->image_count ?? 0 }} images</p>
                    </div>
                </div>
            </div>

            <!-- SEO Information -->
            @if($gallery->meta_title || $gallery->meta_description)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">SEO Information</h3>

                <div class="space-y-4">
                    @if($gallery->meta_title)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Meta Title</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $gallery->meta_title }}</p>
                    </div>
                    @endif

                    @if($gallery->meta_description)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Meta Description</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $gallery->meta_description }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Publication Status</label>
                        @if($gallery->status === 'published')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Published
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Draft
                        </span>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Created</label>
                        <p class="text-sm text-gray-900">{{ $gallery->created_at->format('M d, Y h:i A') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Updated</label>
                        <p class="text-sm text-gray-900">{{ $gallery->updated_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>

                <div class="space-y-2">
                    @can('edit galleries')
                    <a href="{{ route('admin.galleries.edit', $gallery) }}"
                       class="block w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-center">
                        Edit Gallery
                    </a>
                    @endcan

                    @can('delete galleries')
                    <form action="{{ route('admin.galleries.destroy', $gallery) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this gallery? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="block w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            Delete Gallery
                        </button>
                    </form>
                    @endcan

                    <a href="{{ route('admin.galleries.index') }}"
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-center">
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
