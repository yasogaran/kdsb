@extends('admin.layouts.app')

@section('title', 'Edit Event')
@section('page-title', 'Edit Event')

@section('breadcrumbs')
    <a href="{{ route('admin.events.index') }}" class="text-primary hover:text-amber-800">Events</a>
    <span class="mx-2">/</span>
    <span>Edit: {{ Str::limit($event->title, 30) }}</span>
@endsection

@section('content')
<div class="max-w-5xl">
    <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" id="eventForm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Event Information</h3>

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Event Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title', $event->title) }}"
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
                               value="{{ old('slug', $event->slug) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('slug') border-red-500 @enderror">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Auto-generated from title if left empty</p>
                    </div>
                </div>

                <!-- Date & Time -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Schedule</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Start Date/Time -->
                        <div>
                            <label for="start_datetime" class="block text-sm font-medium text-gray-700 mb-2">
                                Start Date & Time <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local"
                                   name="start_datetime"
                                   id="start_datetime"
                                   value="{{ old('start_datetime', $event->start_datetime ? $event->start_datetime->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('start_datetime') border-red-500 @enderror"
                                   required>
                            @error('start_datetime')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- End Date/Time -->
                        <div>
                            <label for="end_datetime" class="block text-sm font-medium text-gray-700 mb-2">
                                End Date & Time <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local"
                                   name="end_datetime"
                                   id="end_datetime"
                                   value="{{ old('end_datetime', $event->end_datetime ? $event->end_datetime->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('end_datetime') border-red-500 @enderror"
                                   required>
                            @error('end_datetime')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Registration Deadline -->
                        <div class="md:col-span-2">
                            <label for="registration_deadline" class="block text-sm font-medium text-gray-700 mb-2">
                                Registration Deadline
                            </label>
                            <input type="datetime-local"
                                   name="registration_deadline"
                                   id="registration_deadline"
                                   value="{{ old('registration_deadline', $event->registration_deadline ? $event->registration_deadline->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('registration_deadline') border-red-500 @enderror">
                            @error('registration_deadline')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Optional deadline for event registration</p>
                        </div>
                    </div>
                </div>

                <!-- Location -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Location Details</h3>

                    <!-- Location Type -->
                    <div class="mb-4">
                        <label for="location_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Location Type <span class="text-red-500">*</span>
                        </label>
                        <select name="location_type"
                                id="location_type"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('location_type') border-red-500 @enderror"
                                required
                                onchange="toggleLocationFields()">
                            <option value="">Select Location Type</option>
                            <option value="physical" {{ old('location_type') == 'physical' ? 'selected' : '' }}>Physical</option>
                            <option value="virtual" {{ old('location_type') == 'virtual' ? 'selected' : '' }}>Virtual</option>
                            <option value="hybrid" {{ old('location_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                        </select>
                        @error('location_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Physical Location Fields -->
                    <div id="physicalFields" class="space-y-4 hidden">
                        <div>
                            <label for="venue_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Venue Name
                            </label>
                            <input type="text"
                                   name="venue_name"
                                   id="venue_name"
                                   value="{{ old('venue_name', $event->venue_name) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('venue_name') border-red-500 @enderror">
                            @error('venue_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                Address
                            </label>
                            <textarea name="address"
                                      id="address"
                                      rows="2"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('address') border-red-500 @enderror">{{ old('address', $event->address) }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="map_link" class="block text-sm font-medium text-gray-700 mb-2">
                                Google Maps Link
                            </label>
                            <input type="url"
                                   name="map_link"
                                   id="map_link"
                                   value="{{ old('map_link', $event->map_link) }}"
                                   placeholder="https://maps.google.com/..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('map_link') border-red-500 @enderror">
                            @error('map_link')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Virtual Meeting Fields -->
                    <div id="virtualFields" class="space-y-4 hidden">
                        <div>
                            <label for="meeting_url" class="block text-sm font-medium text-gray-700 mb-2">
                                Meeting URL
                            </label>
                            <input type="url"
                                   name="meeting_url"
                                   id="meeting_url"
                                   value="{{ old('meeting_url', $event->meeting_url) }}"
                                   placeholder="https://zoom.us/j/..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('meeting_url') border-red-500 @enderror">
                            @error('meeting_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Zoom, Google Meet, Microsoft Teams, etc.</p>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Event Description</h3>

                    <!-- Summary -->
                    <div class="mb-4">
                        <label for="summary" class="block text-sm font-medium text-gray-700 mb-2">
                            Summary <span class="text-red-500">*</span>
                        </label>
                        <textarea name="summary"
                                  id="summary"
                                  rows="3"
                                  maxlength="500"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('summary') border-red-500 @enderror"
                                  required
                                  placeholder="Brief overview of the event...">{{ old('summary', $event->summary) }}</textarea>
                        @error('summary')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Maximum 500 characters</p>
                    </div>

                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                            Full Description <span class="text-red-500">*</span>
                        </label>
                        <textarea name="content"
                                  id="content"
                                  rows="15"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('content') border-red-500 @enderror"
                                  required>{{ old('content', $event->content) }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Organizer Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Organizer Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="organized_by" class="block text-sm font-medium text-gray-700 mb-2">
                                Organized By
                            </label>
                            <input type="text"
                                   name="organized_by"
                                   id="organized_by"
                                   value="{{ old('organized_by', $event->organized_by) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('organized_by') border-red-500 @enderror">
                            @error('organized_by')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="organization_link" class="block text-sm font-medium text-gray-700 mb-2">
                                Organization Website
                            </label>
                            <input type="url"
                                   name="organization_link"
                                   id="organization_link"
                                   value="{{ old('organization_link', $event->organization_link) }}"
                                   placeholder="https://..."
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('organization_link') border-red-500 @enderror">
                            @error('organization_link')
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
                                   value="{{ old('meta_title', $event->meta_title) }}"
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
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('meta_description') border-red-500 @enderror">{{ old('meta_description', $event->meta_description) }}</textarea>
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
                        <option value="draft" {{ old('status', $event->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $event->status) == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Banner Image -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Banner Image</h3>

                    @if($event->banner_image)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Banner</label>
                        <img src="{{ asset('storage/' . $event->banner_image) }}"
                             alt="Banner"
                             class="w-full rounded-lg border border-gray-300">
                    </div>
                    @endif

                    <input type="file"
                           name="banner_image"
                           id="banner_image"
                           accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('banner_image') border-red-500 @enderror"
                           onchange="previewImage(event, 'bannerPreview')">
                    @error('banner_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Max: 2MB. Recommended: 1200x600px @if($event->banner_image) • Leave empty to keep current @endif</p>

                    <div id="bannerPreview" class="mt-4 hidden">
                        <img id="bannerPreviewImg" src="" alt="Preview" class="w-full rounded-lg border border-gray-300">
                    </div>
                </div>

                <!-- Thumbnail Image -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Thumbnail Image</h3>

                    @if($event->thumbnail_image)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Thumbnail</label>
                        <img src="{{ asset('storage/' . $event->thumbnail_image) }}"
                             alt="Thumbnail"
                             class="w-full rounded-lg border border-gray-300">
                    </div>
                    @endif

                    <input type="file"
                           name="thumbnail_image"
                           id="thumbnail_image"
                           accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('thumbnail_image') border-red-500 @enderror"
                           onchange="previewImage(event, 'thumbnailPreview')">
                    @error('thumbnail_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Max: 2MB. Recommended: 600x400px @if($event->thumbnail_image) • Leave empty to keep current @endif</p>

                    <div id="thumbnailPreview" class="mt-4 hidden">
                        <img id="thumbnailPreviewImg" src="" alt="Preview" class="w-full rounded-lg border border-gray-300">
                    </div>
                </div>

                <!-- OG Image -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Social Share Image</h3>

                    @if($event->og_image)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current OG Image</label>
                        <img src="{{ asset('storage/' . $event->og_image) }}"
                             alt="OG Image"
                             class="w-full rounded-lg border border-gray-300">
                    </div>
                    @endif

                    <input type="file"
                           name="og_image"
                           id="og_image"
                           accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('og_image') border-red-500 @enderror"
                           onchange="previewImage(event, 'ogPreview')">
                    @error('og_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Max: 2MB. Recommended: 1200x630px @if($event->og_image) • Leave empty to keep current @endif</p>

                    <div id="ogPreview" class="mt-4 hidden">
                        <img id="ogPreviewImg" src="" alt="Preview" class="w-full rounded-lg border border-gray-300">
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="space-y-2">
                        <button type="submit"
                                class="w-full px-6 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
                            Update Event
                        </button>
                        <a href="{{ route('admin.events.index') }}"
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
            height: 400,
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

        // Initialize location fields on page load if old value exists
        toggleLocationFields();
    });

    // Generate slug from title
    function generateSlug() {
        const title = document.getElementById('title').value;
        const slug = title.toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
        document.getElementById('slug').value = slug;
    }

    // Toggle location fields based on type
    function toggleLocationFields() {
        const locationType = document.getElementById('location_type').value;
        const physicalFields = document.getElementById('physicalFields');
        const virtualFields = document.getElementById('virtualFields');

        physicalFields.classList.add('hidden');
        virtualFields.classList.add('hidden');

        if (locationType === 'physical' || locationType === 'hybrid') {
            physicalFields.classList.remove('hidden');
        }
        if (locationType === 'virtual' || locationType === 'hybrid') {
            virtualFields.classList.remove('hidden');
        }
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
