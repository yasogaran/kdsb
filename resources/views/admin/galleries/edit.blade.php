@extends('admin.layouts.app')

@section('title', 'Edit Gallery')
@section('page-title', 'Edit Gallery')

@section('breadcrumbs')
    <a href="{{ route('admin.galleries.index') }}" class="text-primary hover:text-amber-800">Galleries</a>
    <span class="mx-2">/</span>
    <span>Edit: {{ Str::limit($gallery->title, 30) }}</span>
@endsection

@section('content')
<div class="max-w-5xl">
    <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Gallery Information</h3>

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Gallery Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title', $gallery->title) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('title') border-red-500 @enderror"
                               required
                               autofocus
                               onkeyup="generateSlug()">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                            Slug
                        </label>
                        <input type="text"
                               name="slug"
                               id="slug"
                               value="{{ old('slug', $gallery->slug) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('slug') border-red-500 @enderror">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Auto-generated from title if left empty</p>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-lg shadow p-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea name="description"
                              id="description"
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('description') border-red-500 @enderror"
                              placeholder="Brief description of the gallery...">{{ old('description', $gallery->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gallery Settings -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Gallery Settings</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Event -->
                        <div>
                            <label for="event_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Related Event
                            </label>
                            <select name="event_id"
                                    id="event_id"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('event_id') border-red-500 @enderror">
                                <option value="">None</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}" {{ old('event_id', $gallery->event_id) == $event->id ? 'selected' : '' }}>
                                        {{ $event->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('event_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date Taken -->
                        <div>
                            <label for="date_taken" class="block text-sm font-medium text-gray-700 mb-2">
                                Date Taken
                            </label>
                            <input type="date"
                                   name="date_taken"
                                   id="date_taken"
                                   value="{{ old('date_taken', $gallery->date_taken ? $gallery->date_taken->format('Y-m-d') : '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('date_taken') border-red-500 @enderror">
                            @error('date_taken')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Layout Type -->
                        <div>
                            <label for="layout_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Layout Type
                            </label>
                            <select name="layout_type"
                                    id="layout_type"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('layout_type') border-red-500 @enderror">
                                <option value="grid" {{ old('layout_type', $gallery->layout_type) == 'grid' ? 'selected' : '' }}>Grid</option>
                                <option value="masonry" {{ old('layout_type', $gallery->layout_type) == 'masonry' ? 'selected' : '' }}>Masonry</option>
                                <option value="carousel" {{ old('layout_type', $gallery->layout_type) == 'carousel' ? 'selected' : '' }}>Carousel</option>
                            </select>
                            @error('layout_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Visibility -->
                        <div>
                            <label for="visibility" class="block text-sm font-medium text-gray-700 mb-2">
                                Visibility
                            </label>
                            <select name="visibility"
                                    id="visibility"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('visibility') border-red-500 @enderror">
                                <option value="public" {{ old('visibility', $gallery->visibility) == 'public' ? 'selected' : '' }}>Public</option>
                                <option value="private" {{ old('visibility', $gallery->visibility) == 'private' ? 'selected' : '' }}>Private</option>
                            </select>
                            @error('visibility')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">SEO Settings</h3>

                    <div class="space-y-4">
                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">
                                Meta Title
                            </label>
                            <input type="text"
                                   name="meta_title"
                                   id="meta_title"
                                   value="{{ old('meta_title', $gallery->meta_title) }}"
                                   maxlength="60"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('meta_title') border-red-500 @enderror">
                            @error('meta_title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Maximum 60 characters</p>
                        </div>

                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">
                                Meta Description
                            </label>
                            <textarea name="meta_description"
                                      id="meta_description"
                                      rows="2"
                                      maxlength="160"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('meta_description') border-red-500 @enderror">{{ old('meta_description', $gallery->meta_description) }}</textarea>
                            @error('meta_description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Maximum 160 characters</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Column -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Status -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Publish</h3>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status"
                            id="status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('status') border-red-500 @enderror"
                            required>
                        <option value="draft" {{ old('status', $gallery->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $gallery->status) == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cover Image -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Cover Image</h3>

                    @if($gallery->cover_image)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Cover</label>
                        <img src="{{ asset('storage/' . $gallery->cover_image) }}"
                             alt="Cover"
                             class="w-full rounded-lg border border-gray-300">
                    </div>
                    @endif

                    <input type="file"
                           name="cover_image"
                           id="cover_image"
                           accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('cover_image') border-red-500 @enderror"
                           onchange="previewImage(event, 'coverPreview')">
                    @error('cover_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Max: 2MB. Recommended: 1200x800px @if($gallery->cover_image) • Leave empty to keep current @endif</p>

                    <div id="coverPreview" class="mt-4 hidden">
                        <img id="coverPreviewImg" src="" alt="Preview" class="w-full rounded-lg border border-gray-300">
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="space-y-2">
                        <button type="submit"
                                class="w-full px-6 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
                            Update Gallery
                        </button>
                        <a href="{{ route('admin.galleries.index') }}"
                           class="block w-full px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-center">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Gallery Images Management -->
    <div class="mt-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Gallery Images</h3>
                    <p class="text-sm text-gray-600 mt-1">Upload and manage images for this gallery ({{ $gallery->image_count }} images)</p>
                </div>
            </div>

            <!-- Upload Images Form -->
            <form id="uploadImagesForm" class="mb-6">
                @csrf
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary transition">
                    <input type="file"
                           id="galleryImages"
                           name="images[]"
                           multiple
                           accept="image/*"
                           class="hidden"
                           onchange="handleImageUpload(event)">
                    <label for="galleryImages" class="cursor-pointer">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">
                            <span class="font-semibold text-primary">Click to upload</span> or drag and drop
                        </p>
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 12MB each • Max total: 100MB</p>
                    </label>
                </div>
                <div id="uploadProgress" class="hidden mt-4">
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                        <span id="uploadMessage">Uploading images...</span>
                    </div>
                </div>
            </form>

            <!-- Existing Images Grid with Drag & Drop -->
            <div id="imagesContainer">
                @if($gallery->images->count() > 0)
                <div id="sortableImages" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($gallery->images as $image)
                    <div class="image-item bg-white border border-gray-300 rounded-lg p-4 hover:shadow-lg transition cursor-move" data-id="{{ $image->id }}">
                        <!-- Drag Handle -->
                        <div class="flex items-center justify-between mb-2">
                            <svg class="w-6 h-6 text-gray-400 cursor-move" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
                            </svg>
                            <button type="button"
                                    onclick="deleteImage({{ $image->id }})"
                                    class="text-red-600 hover:text-red-800 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Image -->
                        <img src="{{ asset('storage/' . $image->image_path) }}"
                             alt="{{ $image->caption }}"
                             class="w-full h-48 object-cover rounded-lg mb-3">

                        <!-- Caption Input -->
                        <input type="text"
                               value="{{ $image->caption }}"
                               placeholder="Add caption..."
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-transparent"
                               onblur="updateCaption({{ $image->id }}, this.value)">

                        <p class="text-xs text-gray-500 mt-2">Order: <span class="sort-order">{{ $image->sort_order }}</span></p>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12 bg-gray-50 rounded-lg">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-600">No images yet. Upload your first image above!</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    // Generate slug from title
    function generateSlug() {
        const title = document.getElementById('title').value;
        const slug = title.toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
        document.getElementById('slug').value = slug;
    }

    // Preview image
    function previewImage(event, previewId) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById(previewId);
                const img = preview.querySelector('img');
                img.src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    // Initialize Sortable for drag & drop
    const sortableImages = document.getElementById('sortableImages');
    if (sortableImages) {
        new Sortable(sortableImages, {
            animation: 150,
            handle: '.image-item',
            ghostClass: 'opacity-50',
            onEnd: function(evt) {
                updateImageOrder();
            }
        });
    }

    // Handle image upload
    function handleImageUpload(event) {
        const files = event.target.files;
        if (files.length === 0) return;

        // Validate individual file sizes and total size
        const maxFileSize = 12 * 1024 * 1024; // 12MB in bytes
        const maxTotalSize = 100 * 1024 * 1024; // 100MB in bytes
        let totalSize = 0;
        let hasOversizedFile = false;
        let oversizedFileName = '';

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            totalSize += file.size;

            // Check individual file size
            if (file.size > maxFileSize) {
                hasOversizedFile = true;
                oversizedFileName = file.name;
                break;
            }
        }

        // Show error if individual file is too large
        if (hasOversizedFile) {
            alert(`Error: "${oversizedFileName}" exceeds the maximum file size of 12MB. Please compress or resize the image before uploading.`);
            event.target.value = '';
            return;
        }

        // Show error if total size exceeds limit
        if (totalSize > maxTotalSize) {
            const totalSizeMB = (totalSize / 1024 / 1024).toFixed(2);
            alert(`Error: Total upload size (${totalSizeMB} MB) exceeds the maximum limit of 100 MB. Please reduce the number of images or compress them before uploading.`);
            event.target.value = '';
            return;
        }

        const formData = new FormData();
        for (let i = 0; i < files.length; i++) {
            formData.append('images[]', files[i]);
        }

        // Show progress with size info
        const totalSizeMB = (totalSize / 1024 / 1024).toFixed(2);
        document.getElementById('uploadProgress').classList.remove('hidden');
        document.getElementById('uploadMessage').textContent = `Uploading ${files.length} image(s) (${totalSizeMB} MB)...`;

        fetch('{{ route("admin.galleries.images.store", $gallery) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                document.getElementById('uploadMessage').textContent = data.message;
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                alert('Error uploading images: ' + (data.message || 'Unknown error'));
                document.getElementById('uploadProgress').classList.add('hidden');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error uploading images. Please try again.');
            document.getElementById('uploadProgress').classList.add('hidden');
        });

        // Reset file input
        event.target.value = '';
    }

    // Update image order after drag & drop
    function updateImageOrder() {
        const imageItems = document.querySelectorAll('.image-item');
        const order = Array.from(imageItems).map(item => item.dataset.id);

        fetch('{{ route("admin.galleries.images.order", $gallery) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || '{{ csrf_token() }}'
            },
            body: JSON.stringify({ order: order })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update sort order display
                imageItems.forEach((item, index) => {
                    item.querySelector('.sort-order').textContent = index + 1;
                });
            }
        })
        .catch(error => {
            console.error('Error updating order:', error);
            alert('Error updating image order. Please refresh and try again.');
        });
    }

    // Update image caption
    function updateCaption(imageId, caption) {
        fetch(`/admin/gallery-images/${imageId}/caption`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || '{{ csrf_token() }}'
            },
            body: JSON.stringify({ caption: caption })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert('Error updating caption');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // Delete image
    function deleteImage(imageId) {
        if (!confirm('Are you sure you want to delete this image?')) {
            return;
        }

        fetch(`/admin/gallery-images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content || '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the image item from DOM
                const imageItem = document.querySelector(`[data-id="${imageId}"]`);
                if (imageItem) {
                    imageItem.remove();
                }
                // Reload to update count
                setTimeout(() => window.location.reload(), 500);
            } else {
                alert('Error deleting image');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting image. Please try again.');
        });
    }
</script>
@endpush
@endsection
