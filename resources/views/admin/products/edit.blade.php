@extends('admin.layouts.app')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('breadcrumbs')
    <a href="{{ route('admin.products.index') }}" class="text-primary hover:text-amber-800">Products</a>
    <span class="mx-2">/</span>
    <span>Edit: {{ Str::limit($product->title, 30) }}</span>
@endsection

@section('content')
<div class="max-w-5xl">
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Information</h3>

                    <!-- Title -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Product Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               id="title"
                               value="{{ old('title', $product->title) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('title') border-red-500 @enderror"
                               required
                               autofocus
                               onkeyup="generateSlug()">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="mb-4">
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                            Slug
                        </label>
                        <input type="text"
                               name="slug"
                               id="slug"
                               value="{{ old('slug', $product->slug) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('slug') border-red-500 @enderror">
                        @error('slug')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Auto-generated from title if left empty</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- SKU -->
                        <div>
                            <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">
                                SKU <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="sku"
                                   id="sku"
                                   value="{{ old('sku', $product->sku) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('sku') border-red-500 @enderror"
                                   required>
                            @error('sku')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Group -->
                        <div>
                            <label for="group" class="block text-sm font-medium text-gray-700 mb-2">
                                Group
                            </label>
                            <input type="text"
                                   name="group"
                                   id="group"
                                   value="{{ old('group', $product->group) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('group') border-red-500 @enderror">
                            @error('group')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Product Identity & SEO Data -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Identity & SEO Data</h3>
                    <p class="text-sm text-gray-600 mb-4">These fields improve search engine visibility and product identification</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Brand -->
                        <div>
                            <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">
                                Brand
                            </label>
                            <input type="text"
                                   name="brand"
                                   id="brand"
                                   value="{{ old('brand', $product->brand) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('brand') border-red-500 @enderror"
                                   placeholder="e.g., Scout Essentials">
                            @error('brand')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Manufacturer or brand name</p>
                        </div>

                        <!-- Condition -->
                        <div>
                            <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">
                                Condition
                            </label>
                            <select name="condition"
                                    id="condition"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('condition') border-red-500 @enderror">
                                <option value="new" {{ old('condition', $product->condition ?? 'new') == 'new' ? 'selected' : '' }}>New</option>
                                <option value="refurbished" {{ old('condition', $product->condition) == 'refurbished' ? 'selected' : '' }}>Refurbished</option>
                                <option value="used" {{ old('condition', $product->condition) == 'used' ? 'selected' : '' }}>Used</option>
                            </select>
                            @error('condition')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- GTIN/Barcode -->
                        <div>
                            <label for="gtin" class="block text-sm font-medium text-gray-700 mb-2">
                                GTIN / Barcode
                            </label>
                            <input type="text"
                                   name="gtin"
                                   id="gtin"
                                   value="{{ old('gtin', $product->gtin) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('gtin') border-red-500 @enderror"
                                   placeholder="e.g., 0123456789012">
                            @error('gtin')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Global Trade Item Number</p>
                        </div>

                        <!-- MPN -->
                        <div>
                            <label for="mpn" class="block text-sm font-medium text-gray-700 mb-2">
                                MPN
                            </label>
                            <input type="text"
                                   name="mpn"
                                   id="mpn"
                                   value="{{ old('mpn', $product->mpn) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('mpn') border-red-500 @enderror"
                                   placeholder="e.g., SC-1234">
                            @error('mpn')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Manufacturer Part Number</p>
                        </div>

                        <!-- Currency -->
                        <div>
                            <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">
                                Currency
                            </label>
                            <select name="currency"
                                    id="currency"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('currency') border-red-500 @enderror">
                                <option value="LKR" {{ old('currency', $product->currency ?? 'LKR') == 'LKR' ? 'selected' : '' }}>LKR - Sri Lankan Rupee</option>
                                <option value="USD" {{ old('currency', $product->currency) == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                                <option value="EUR" {{ old('currency', $product->currency) == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                            </select>
                            @error('currency')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Price Valid Until -->
                        <div>
                            <label for="price_valid_until" class="block text-sm font-medium text-gray-700 mb-2">
                                Price Valid Until
                            </label>
                            <input type="date"
                                   name="price_valid_until"
                                   id="price_valid_until"
                                   value="{{ old('price_valid_until', $product->price_valid_until?->format('Y-m-d')) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('price_valid_until') border-red-500 @enderror">
                            @error('price_valid_until')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Optional: When current price expires</p>
                        </div>
                    </div>

                    <!-- Availability Date (full width) -->
                    <div class="mt-4">
                        <label for="availability_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Availability Date (if out of stock)
                        </label>
                        <input type="date"
                               name="availability_date"
                               id="availability_date"
                               value="{{ old('availability_date', $product->availability_date?->format('Y-m-d')) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('availability_date') border-red-500 @enderror">
                        @error('availability_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">When product will be back in stock (for pre-orders)</p>
                    </div>
                </div>

                <!-- About & Description -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Details</h3>

                    <!-- About -->
                    <div class="mb-4">
                        <label for="about" class="block text-sm font-medium text-gray-700 mb-2">
                            About
                        </label>
                        <textarea name="about"
                                  id="about"
                                  rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('about') border-red-500 @enderror"
                                  placeholder="Brief product summary...">{{ old('about', $product->about) }}</textarea>
                        @error('about')
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
                                  rows="8"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Pricing & Stock -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pricing & Inventory</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                Price <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                                <input type="number"
                                       name="price"
                                       id="price"
                                       value="{{ old('price', $product->price) }}"
                                       step="0.01"
                                       min="0"
                                       class="w-full pl-7 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('price') border-red-500 @enderror"
                                       required>
                            </div>
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sale Price -->
                        <div>
                            <label for="sale_price" class="block text-sm font-medium text-gray-700 mb-2">
                                Sale Price
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                                <input type="number"
                                       name="sale_price"
                                       id="sale_price"
                                       value="{{ old('sale_price', $product->sale_price) }}"
                                       step="0.01"
                                       min="0"
                                       class="w-full pl-7 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('sale_price') border-red-500 @enderror">
                            </div>
                            @error('sale_price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label for="qty" class="block text-sm font-medium text-gray-700 mb-2">
                                Quantity <span class="text-red-500">*</span>
                            </label>
                            <input type="number"
                                   name="qty"
                                   id="qty"
                                   value="{{ old('qty', $product->qty) }}"
                                   min="0"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('qty') border-red-500 @enderror"
                                   required>
                            @error('qty')
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
                                   value="{{ old('meta_title', $product->meta_title) }}"
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
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('meta_description') border-red-500 @enderror">{{ old('meta_description', $product->meta_description) }}</textarea>
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
                <!-- Status & Category -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Organization</h3>

                    <!-- Category -->
                    <div class="mb-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id"
                                id="category_id"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('category_id') border-red-500 @enderror"
                                required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status"
                                id="status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('status') border-red-500 @enderror"
                                required>
                            <option value="available" {{ old('status', $product->status) == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="out_of_stock" {{ old('status', $product->status) == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                            <option value="discontinued" {{ old('status', $product->status) == 'discontinued' ? 'selected' : '' }}>Discontinued</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Primary Image -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Primary Image</h3>

                    @if($product->primary_image)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                        <img src="{{ asset('storage/' . $product->primary_image) }}"
                             alt="Product Image"
                             class="w-full rounded-lg border border-gray-300">
                    </div>
                    @endif

                    <input type="file"
                           name="primary_image"
                           id="primary_image"
                           accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('primary_image') border-red-500 @enderror"
                           onchange="previewImage(event, 'imagePreview')">
                    @error('primary_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Max: 2MB. Recommended: 800x800px @if($product->primary_image) • Leave empty to keep current @endif</p>

                    <div id="imagePreview" class="mt-4 hidden">
                        <img id="imagePreviewImg" src="" alt="Preview" class="w-full rounded-lg border border-gray-300">
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="space-y-2">
                        <button type="submit"
                                class="w-full px-6 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
                            Update Product
                        </button>
                        <a href="{{ route('admin.products.index') }}"
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
        $('#description').summernote({
            height: 300,
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
