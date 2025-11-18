@extends('admin.layouts.app')

@section('title', 'Syllabi')
@section('page-title', 'Syllabus Management')

@section('breadcrumbs')
    <span>Academic Management / Syllabi</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Header with Action Button -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">Manage course syllabi and academic resources</p>
        </div>
        <a href="{{ route('admin.syllabi.create') }}"
           class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Syllabus
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4">
        <form method="GET" action="{{ route('admin.syllabi.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
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

            <!-- Category Filter -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category"
                        id="category"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">All Categories</option>
                    <option value="undergraduate" {{ request('category') == 'undergraduate' ? 'selected' : '' }}>Undergraduate</option>
                    <option value="graduate" {{ request('category') == 'graduate' ? 'selected' : '' }}>Graduate</option>
                    <option value="diploma" {{ request('category') == 'diploma' ? 'selected' : '' }}>Diploma</option>
                    <option value="certificate" {{ request('category') == 'certificate' ? 'selected' : '' }}>Certificate</option>
                </select>
            </div>

            <!-- Resource Type Filter -->
            <div>
                <label for="resource_type" class="block text-sm font-medium text-gray-700 mb-1">Resource Type</label>
                <select name="resource_type"
                        id="resource_type"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">All Types</option>
                    <option value="file" {{ request('resource_type') == 'file' ? 'selected' : '' }}>File Upload</option>
                    <option value="url" {{ request('resource_type') == 'url' ? 'selected' : '' }}>External URL</option>
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label for="is_active" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="is_active"
                        id="is_active"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <!-- Filter Buttons -->
            <div class="md:col-span-4 flex items-center space-x-2">
                <button type="submit"
                        class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
                    Apply Filters
                </button>
                <a href="{{ route('admin.syllabi.index') }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Syllabi Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Title
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Category
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Resource Type
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Published Date
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($syllabi as $syllabus)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded bg-blue-100">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $syllabus->title }}</div>
                                @if($syllabus->description)
                                <div class="text-sm text-gray-500">{{ Str::limit($syllabus->description, 50) }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 capitalize">
                            {{ $syllabus->category }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 capitalize">
                        {{ $syllabus->resource_type }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $syllabus->published_date ? $syllabus->published_date->format('M d, Y') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($syllabus->is_active)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Active
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Inactive
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                        @can('view syllabi')
                        <a href="{{ route('admin.syllabi.show', $syllabus) }}"
                           class="text-gray-600 hover:text-gray-900">
                            View
                        </a>
                        @endcan

                        @can('edit syllabi')
                        <a href="{{ route('admin.syllabi.edit', $syllabus) }}"
                           class="text-blue-600 hover:text-blue-900">
                            Edit
                        </a>
                        @endcan

                        @can('delete syllabi')
                        <form action="{{ route('admin.syllabi.destroy', $syllabus) }}"
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this syllabus?');"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">
                                Delete
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="text-lg font-medium text-gray-900">No syllabi found</p>
                        <p class="text-sm text-gray-500 mt-1">
                            @if(request()->hasAny(['search', 'category', 'resource_type', 'is_active']))
                                Try adjusting your filters
                            @else
                                Get started by adding your first syllabus
                            @endif
                        </p>
                        @if(!request()->hasAny(['search', 'category', 'resource_type', 'is_active']))
                        <a href="{{ route('admin.syllabi.create') }}"
                           class="inline-block mt-4 px-4 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
                            Add Syllabus
                        </a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($syllabi->hasPages())
    <div class="bg-white rounded-lg shadow p-4">
        {{ $syllabi->links() }}
    </div>
    @endif
</div>
@endsection
