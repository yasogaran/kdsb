@extends('admin.layouts.app')

@section('title', 'Edit Post')
@section('page-title', 'Edit Post')

@section('breadcrumbs')
    <a href="{{ route('admin.posts.index') }}" class="text-primary hover:text-amber-800">Blog Posts</a>
    <span class="mx-2">/</span>
    <span>Edit: {{ Str::limit($post->title, 30) }}</span>
@endsection

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Title & Slug -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Post Details</h3>

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title', $post->title) }}"
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
                               value="{{ old('slug', $post->slug) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('slug') border-red-500 @enderror">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Auto-generated from title if left empty</p>
                    </div>
                </div>

                <!-- Excerpt -->
                <div class="bg-white rounded-lg shadow p-6">
                    <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                        Excerpt <span class="text-red-500">*</span>
                    </label>
                    <textarea name="excerpt"
                              id="excerpt"
                              rows="3"
                              maxlength="500"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('excerpt') border-red-500 @enderror"
                              required
                              placeholder="Brief summary of the post...">{{ old('excerpt', $post->excerpt) }}</textarea>
                    @error('excerpt')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Maximum 500 characters</p>
                </div>

                <!-- Content -->
                <div class="bg-white rounded-lg shadow p-6">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                        Content <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content"
                              id="content"
                              rows="15"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('content') border-red-500 @enderror"
                              required>{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SEO Settings -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">SEO Settings</h3>

                    <!-- Meta Title -->
                    <div class="mb-4">
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">
                            Meta Title
                        </label>
                        <input type="text"
                               name="meta_title"
                               id="meta_title"
                               value="{{ old('meta_title', $post->meta_title) }}"
                               maxlength="60"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('meta_title') border-red-500 @enderror">
                        @error('meta_title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Maximum 60 characters (defaults to post title)</p>
                    </div>

                    <!-- Meta Description -->
                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Meta Description
                        </label>
                        <textarea name="meta_description"
                                  id="meta_description"
                                  rows="2"
                                  maxlength="160"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('meta_description') border-red-500 @enderror">{{ old('meta_description', $post->meta_description) }}</textarea>
                        @error('meta_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Maximum 160 characters (defaults to excerpt)</p>
                    </div>
                </div>
            </div>

            <!-- Sidebar Column -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Publish Settings -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Publish</h3>

                    <!-- Status -->
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status"
                                id="status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('status') border-red-500 @enderror"
                                required>
                            <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Published At -->
                    <div class="mb-4">
                        <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">
                            Publish Date
                        </label>
                        <input type="datetime-local"
                               name="published_at"
                               id="published_at"
                               value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('published_at') border-red-500 @enderror">
                        @error('published_at')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Leave empty for current date/time</p>
                    </div>

                    <!-- Featured -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox"
                                   name="is_featured"
                                   value="1"
                                   {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-primary focus:ring-primary">
                            <span class="ml-2 text-sm text-gray-700">Featured Post</span>
                        </label>
                    </div>
                </div>

                <!-- Category -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Category</h3>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id"
                            id="category_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('category_id') border-red-500 @enderror"
                            required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Featured Image -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Featured Image</h3>

                    @if($post->image)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                        <img src="{{ asset('storage/' . $post->image) }}"
                             alt="{{ $post->title }}"
                             class="w-full rounded-lg border border-gray-300">
                    </div>
                    @endif

                    <input type="file"
                           name="image"
                           id="image"
                           accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('image') border-red-500 @enderror"
                           onchange="previewImage(event, 'imagePreview')">
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        Max: 2MB. Recommended: 1200x800px
                        @if($post->image) • Leave empty to keep current @endif
                    </p>

                    <div id="imagePreview" class="mt-4 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">New Image Preview</label>
                        <img id="imagePreviewImg" src="" alt="Preview" class="w-full rounded-lg border border-gray-300">
                    </div>
                </div>

                <!-- OG Image -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Social Share Image</h3>

                    @if($post->og_image)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current OG Image</label>
                        <img src="{{ asset('storage/' . $post->og_image) }}"
                             alt="OG Image"
                             class="w-full rounded-lg border border-gray-300">
                    </div>
                    @endif

                    <input type="file"
                           name="og_image"
                           id="og_image"
                           accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('og_image') border-red-500 @enderror"
                           onchange="previewImage(event, 'ogImagePreview')">
                    @error('og_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        Optional. Max: 2MB. Used for social media sharing
                        @if($post->og_image) • Leave empty to keep current @endif
                    </p>

                    <div id="ogImagePreview" class="mt-4 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">New OG Image Preview</label>
                        <img id="ogImagePreviewImg" src="" alt="OG Preview" class="w-full rounded-lg border border-gray-300">
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="space-y-2">
                        <button type="submit"
                                class="w-full px-6 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
                            Update Post
                        </button>
                        <a href="{{ route('admin.posts.index') }}"
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
        $('#content').summernote({
            height: 500,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });

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
</script>
@endpush
@endsection
