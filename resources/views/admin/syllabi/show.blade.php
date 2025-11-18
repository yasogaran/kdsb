@extends('admin.layouts.app')

@section('title', 'View Syllabus')
@section('page-title', $syllabus->title)

@section('breadcrumbs')
    <a href="{{ route('admin.syllabi.index') }}" class="text-primary hover:text-amber-800">Syllabi</a>
    <span class="mx-2">/</span>
    <span>{{ Str::limit($syllabus->title, 30) }}</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Action Buttons -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">View syllabus details and resource</p>
        </div>
        <div class="flex items-center space-x-2">
            @can('edit syllabi')
            <a href="{{ route('admin.syllabi.edit', $syllabus) }}"
               class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Syllabus
            </a>
            @endcan
        </div>
    </div>

    <!-- Syllabus Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Syllabus Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Syllabus Information</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $syllabus->title }}</p>
                    </div>

                    @if($syllabus->description)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $syllabus->description }}</p>
                    </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Category</label>
                            <p class="mt-1 text-sm text-gray-900 capitalize">{{ $syllabus->category }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Resource Type</label>
                            <p class="mt-1 text-sm text-gray-900 capitalize">{{ $syllabus->resource_type }}</p>
                        </div>
                    </div>

                    @if($syllabus->published_date)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Published Date</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $syllabus->published_date->format('M d, Y') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Resource -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Resource</h3>

                @if($syllabus->resource_type === 'file' && $syllabus->file_path)
                <div class="flex items-center p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex-shrink-0 h-12 w-12 flex items-center justify-center rounded bg-blue-100">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-900">{{ basename($syllabus->file_path) }}</p>
                        <p class="text-xs text-gray-500">File Upload</p>
                    </div>
                    <a href="{{ asset('storage/' . $syllabus->file_path) }}"
                       target="_blank"
                       class="ml-4 inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download
                    </a>
                </div>
                @elseif($syllabus->resource_type === 'url' && $syllabus->external_url)
                <div class="flex items-center p-4 bg-purple-50 border border-purple-200 rounded-lg">
                    <div class="flex-shrink-0 h-12 w-12 flex items-center justify-center rounded bg-purple-100">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-900 break-all">{{ $syllabus->external_url }}</p>
                        <p class="text-xs text-gray-500">External URL</p>
                    </div>
                    <a href="{{ $syllabus->external_url }}"
                       target="_blank"
                       class="ml-4 inline-flex items-center px-3 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                        Open
                    </a>
                </div>
                @else
                <div class="text-center py-6 text-gray-500">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-sm">No resource available</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Availability</label>
                        @if($syllabus->is_active)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Active
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Inactive
                        </span>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Created</label>
                        <p class="text-sm text-gray-900">{{ $syllabus->created_at->format('M d, Y h:i A') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Updated</label>
                        <p class="text-sm text-gray-900">{{ $syllabus->updated_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>

                <div class="space-y-2">
                    @can('edit syllabi')
                    <a href="{{ route('admin.syllabi.edit', $syllabus) }}"
                       class="block w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-center">
                        Edit Syllabus
                    </a>
                    @endcan

                    @can('delete syllabi')
                    <form action="{{ route('admin.syllabi.destroy', $syllabus) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this syllabus? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="block w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            Delete Syllabus
                        </button>
                    </form>
                    @endcan

                    <a href="{{ route('admin.syllabi.index') }}"
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-center">
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
