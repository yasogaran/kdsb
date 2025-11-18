@extends('admin.layouts.app')

@section('title', 'Create Circular')
@section('page-title', 'Create Circular')

@section('breadcrumbs')
    <a href="{{ route('admin.circulars.index') }}" class="text-primary hover:text-amber-800">Circulars</a>
    <span class="mx-2">/</span>
    <span>Create</span>
@endsection

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.circulars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Circular Information</h3>

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('title') border-red-500 @enderror"
                               required
                               autofocus>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                            Category
                        </label>
                        <input type="text"
                               name="category"
                               id="category"
                               value="{{ old('category') }}"
                               placeholder="e.g., administrative, academic, general"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('category') border-red-500 @enderror">
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Optional - helps organize circulars</p>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea name="description"
                                  id="description"
                                  rows="4"
                                  class="summernote w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Optional - provide additional details about the circular</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Circular Number -->
                        <div>
                            <label for="circular_number" class="block text-sm font-medium text-gray-700 mb-2">
                                Circular Number <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="circular_number"
                                   id="circular_number"
                                   value="{{ old('circular_number') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('circular_number') border-red-500 @enderror"
                                   required>
                            @error('circular_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Circular Code -->
                        <div>
                            <label for="circular_code" class="block text-sm font-medium text-gray-700 mb-2">
                                Circular Code
                            </label>
                            <input type="text"
                                   name="circular_code"
                                   id="circular_code"
                                   value="{{ old('circular_code') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('circular_code') border-red-500 @enderror">
                            @error('circular_code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Optional reference code</p>
                        </div>
                    </div>
                </div>

                <!-- Published Date -->
                <div class="bg-white rounded-lg shadow p-6">
                    <label for="published_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Published Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           name="published_date"
                           id="published_date"
                           value="{{ old('published_date') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('published_date') border-red-500 @enderror"
                           required>
                    @error('published_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Upload -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Document</h3>

                    <!-- File Type -->
                    <div class="mb-4">
                        <label for="file_type" class="block text-sm font-medium text-gray-700 mb-2">
                            File Type <span class="text-red-500">*</span>
                        </label>
                        <select name="file_type"
                                id="file_type"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('file_type') border-red-500 @enderror"
                                required
                                onchange="toggleFileFields()">
                            <option value="">Select File Type</option>
                            <option value="file" {{ old('file_type') == 'file' ? 'selected' : '' }}>File Upload</option>
                            <option value="url" {{ old('file_type') == 'url' ? 'selected' : '' }}>External Link</option>
                        </select>
                        @error('file_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- File Upload Field -->
                    <div id="fileField" class="hidden">
                        <label for="file_path" class="block text-sm font-medium text-gray-700 mb-2">
                            Upload File <span class="text-red-500">*</span>
                        </label>
                        <input type="file"
                               name="file_path"
                               id="file_path"
                               accept=".pdf,.doc,.docx"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('file_path') border-red-500 @enderror">
                        @error('file_path')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Accepted formats: PDF, DOC, DOCX. Max: 10MB</p>
                    </div>

                    <!-- External Link Field -->
                    <div id="linkField" class="hidden">
                        <label for="external_link" class="block text-sm font-medium text-gray-700 mb-2">
                            External Link <span class="text-red-500">*</span>
                        </label>
                        <input type="url"
                               name="external_link"
                               id="external_link"
                               value="{{ old('external_link') }}"
                               placeholder="https://..."
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('external_link') border-red-500 @enderror">
                        @error('external_link')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Link to external circular document</p>
                    </div>
                </div>
            </div>

            <!-- Sidebar Column -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Pin Status -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Priority</h3>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox"
                                   name="is_pinned"
                                   value="1"
                                   {{ old('is_pinned') ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-primary focus:ring-primary">
                            <span class="ml-2 text-sm text-gray-700">Pin this circular</span>
                        </label>
                        <p class="mt-2 text-xs text-gray-500">Pinned circulars appear at the top of the list</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="space-y-2">
                        <button type="submit"
                                class="w-full px-6 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
                            Create Circular
                        </button>
                        <a href="{{ route('admin.circulars.index') }}"
                           class="block w-full px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-center">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Summernote
        $('.summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });

    // Toggle file fields based on type
    function toggleFileFields() {
        const fileType = document.getElementById('file_type').value;
        const fileField = document.getElementById('fileField');
        const linkField = document.getElementById('linkField');

        fileField.classList.add('hidden');
        linkField.classList.add('hidden');

        if (fileType === 'file') {
            fileField.classList.remove('hidden');
        } else if (fileType === 'url') {
            linkField.classList.remove('hidden');
        }
    }

    // Initialize on page load if old value exists
    document.addEventListener('DOMContentLoaded', function() {
        toggleFileFields();
    });
</script>
@endpush
@endsection
