@extends('admin.layouts.app')

@section('title', 'Edit Syllabus')
@section('page-title', 'Edit Syllabus')

@section('breadcrumbs')
    <a href="{{ route('admin.syllabi.index') }}" class="text-primary hover:text-amber-800">Syllabi</a>
    <span class="mx-2">/</span>
    <span>Edit: {{ Str::limit($syllabus->title, 30) }}</span>
@endsection

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.syllabi.update', $syllabus) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Syllabus Information</h3>

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title', $syllabus->title) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('title') border-red-500 @enderror"
                               required
                               autofocus>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea name="description"
                                  id="description"
                                  rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('description') border-red-500 @enderror"
                                  placeholder="Brief description of the syllabus...">{{ old('description', $syllabus->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Category & Published Date -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Classification</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select name="category"
                                    id="category"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('category') border-red-500 @enderror"
                                    required>
                                <option value="">Select Category</option>
                                <option value="undergraduate" {{ old('category', $syllabus->category) == 'undergraduate' ? 'selected' : '' }}>Undergraduate</option>
                                <option value="graduate" {{ old('category', $syllabus->category) == 'graduate' ? 'selected' : '' }}>Graduate</option>
                                <option value="diploma" {{ old('category', $syllabus->category) == 'diploma' ? 'selected' : '' }}>Diploma</option>
                                <option value="certificate" {{ old('category', $syllabus->category) == 'certificate' ? 'selected' : '' }}>Certificate</option>
                            </select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Published Date -->
                        <div>
                            <label for="published_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Published Date
                            </label>
                            <input type="date"
                                   name="published_date"
                                   id="published_date"
                                   value="{{ old('published_date', $syllabus->published_date ? $syllabus->published_date->format('Y-m-d') : '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('published_date') border-red-500 @enderror">
                            @error('published_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Resource -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Resource</h3>

                    <!-- Current Resource Info -->
                    @if($syllabus->resource_type === 'file' && $syllabus->file_path)
                    <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-sm text-gray-700">Current File: {{ basename($syllabus->file_path) }}</span>
                        </div>
                    </div>
                    @elseif($syllabus->resource_type === 'url' && $syllabus->external_url)
                    <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            <a href="{{ $syllabus->external_url }}" target="_blank" class="text-sm text-blue-600 hover:underline">{{ $syllabus->external_url }}</a>
                        </div>
                    </div>
                    @endif

                    <!-- Resource Type -->
                    <div class="mb-4">
                        <label for="resource_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Resource Type <span class="text-red-500">*</span>
                        </label>
                        <select name="resource_type"
                                id="resource_type"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('resource_type') border-red-500 @enderror"
                                required
                                onchange="toggleResourceFields()">
                            <option value="">Select Resource Type</option>
                            <option value="file" {{ old('resource_type', $syllabus->resource_type) == 'file' ? 'selected' : '' }}>File Upload</option>
                            <option value="url" {{ old('resource_type', $syllabus->resource_type) == 'url' ? 'selected' : '' }}>External URL</option>
                        </select>
                        @error('resource_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- File Upload Field -->
                    <div id="fileField" class="hidden">
                        <label for="file_path" class="block text-sm font-medium text-gray-700 mb-2">
                            Upload New File
                        </label>
                        <input type="file"
                               name="file_path"
                               id="file_path"
                               accept=".pdf,.doc,.docx"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('file_path') border-red-500 @enderror">
                        @error('file_path')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Accepted formats: PDF, DOC, DOCX. Max: 10MB @if($syllabus->resource_type === 'file' && $syllabus->file_path) • Leave empty to keep current file @endif</p>
                    </div>

                    <!-- External URL Field -->
                    <div id="urlField" class="hidden">
                        <label for="external_url" class="block text-sm font-medium text-gray-700 mb-2">
                            External URL
                        </label>
                        <input type="url"
                               name="external_url"
                               id="external_url"
                               value="{{ old('external_url', $syllabus->external_url) }}"
                               placeholder="https://..."
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('external_url') border-red-500 @enderror">
                        @error('external_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Link to external syllabus resource</p>
                    </div>
                </div>
            </div>

            <!-- Sidebar Column -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Status -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $syllabus->is_active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-primary focus:ring-primary">
                            <span class="ml-2 text-sm text-gray-700">Active</span>
                        </label>
                        <p class="mt-2 text-xs text-gray-500">Make this syllabus available to students</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="space-y-2">
                        <button type="submit"
                                class="w-full px-6 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
                            Update Syllabus
                        </button>
                        <a href="{{ route('admin.syllabi.index') }}"
                           class="block w-full px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-center">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Toggle resource fields based on type
    function toggleResourceFields() {
        const resourceType = document.getElementById('resource_type').value;
        const fileField = document.getElementById('fileField');
        const urlField = document.getElementById('urlField');

        fileField.classList.add('hidden');
        urlField.classList.add('hidden');

        if (resourceType === 'file') {
            fileField.classList.remove('hidden');
        } else if (resourceType === 'url') {
            urlField.classList.remove('hidden');
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        toggleResourceFields();
    });
</script>
@endpush
@endsection
