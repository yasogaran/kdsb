@extends('admin.layouts.app')

@section('title', 'Edit Milestone')
@section('page-title', 'Edit Milestone')

@section('breadcrumbs')
    <a href="{{ route('admin.milestones.index') }}" class="text-primary hover:text-amber-800">Milestones</a>
    <span class="mx-2">/</span>
    <span>Edit: {{ $milestone->year }} - {{ $milestone->title }}</span>
@endsection

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.milestones.update', $milestone) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Year -->
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-2">
                        Year <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           name="year"
                           id="year"
                           value="{{ old('year', $milestone->year) }}"
                           min="1900"
                           max="{{ date('Y') + 10 }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('year') border-red-500 @enderror"
                           required
                           autofocus>
                    @error('year')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Display Order -->
                <div>
                    <label for="display_order" class="block text-sm font-medium text-gray-700 mb-2">
                        Display Order
                    </label>
                    <input type="number"
                           name="display_order"
                           id="display_order"
                           value="{{ old('display_order', $milestone->display_order) }}"
                           min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('display_order') border-red-500 @enderror">
                    @error('display_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Lower numbers appear first in timeline</p>
                </div>
            </div>

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Title <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="title"
                       id="title"
                       value="{{ old('title', $milestone->title) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('title') border-red-500 @enderror"
                       required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea name="description"
                          id="description"
                          rows="5"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('description') border-red-500 @enderror"
                          required>{{ old('description', $milestone->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Image -->
            @if($milestone->image)
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                <div class="relative inline-block">
                    <img src="{{ asset('storage/' . $milestone->image) }}"
                         alt="{{ $milestone->title }}"
                         class="max-w-sm rounded-lg border border-gray-300">
                </div>
            </div>
            @endif

            <!-- Image Upload -->
            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $milestone->image ? 'Replace Image' : 'Upload Image' }}
                </label>
                <input type="file"
                       name="image"
                       id="image"
                       accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('image') border-red-500 @enderror"
                       onchange="previewImage(event)">
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">
                    Max size: 2MB. Recommended: 800x600px. Formats: JPG, PNG, GIF
                    @if($milestone->image) • Leave empty to keep current image @endif
                </p>

                <!-- New Image Preview -->
                <div id="imagePreview" class="mt-4 hidden">
                    <p class="text-sm text-gray-700 mb-2">New Image Preview:</p>
                    <img id="preview" src="" alt="Preview" class="max-w-sm rounded-lg border border-gray-300">
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.milestones.index') }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
                    Update Milestone
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
@endsection
