@extends('admin.layouts.app')

@section('title', 'Create Syllabus')
@section('page-title', 'Create Syllabus')

@section('breadcrumbs')
    <a href="{{ route('admin.syllabi.index') }}" class="text-primary hover:text-amber-800">Syllabi</a>
    <span class="mx-2">/</span>
    <span>Create</span>
@endsection

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.syllabi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

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
                               value="{{ old('title') }}"
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
                                  placeholder="Brief description of the syllabus...">{{ old('description') }}</textarea>
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
                            <input type="text"
                                   name="category"
                                   id="category"
                                   value="{{ old('category') }}"
                                   placeholder="e.g., cubs, scouts, rovers"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('category') border-red-500 @enderror"
                                   required>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Single word only (will be saved as lowercase)</p>
                        </div>

                        <!-- Published Date -->
                        <div>
                            <label for="published_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Published Date
                            </label>
                            <input type="date"
                                   name="published_date"
                                   id="published_date"
                                   value="{{ old('published_date') }}"
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
                            <option value="file" {{ old('resource_type') == 'file' ? 'selected' : '' }}>File Upload</option>
                            <option value="url" {{ old('resource_type') == 'url' ? 'selected' : '' }}>External URL</option>
                        </select>
                        @error('resource_type')
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

                    <!-- External URL Field -->
                    <div id="urlField" class="hidden">
                        <label for="external_url" class="block text-sm font-medium text-gray-700 mb-2">
                            External URL <span class="text-red-500">*</span>
                        </label>
                        <input type="url"
                               name="external_url"
                               id="external_url"
                               value="{{ old('external_url') }}"
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
                                   {{ old('is_active', true) ? 'checked' : '' }}
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
                            Create Syllabus
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

    // Initialize on page load if old value exists
    document.addEventListener('DOMContentLoaded', function() {
        toggleResourceFields();
    });
</script>
@endpush
@endsection
