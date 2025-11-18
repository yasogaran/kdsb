@extends('admin.layouts.app')

@section('title', 'View Product')
@section('page-title', $product->title)

@section('breadcrumbs')
    <a href="{{ route('admin.products.index') }}" class="text-primary hover:text-amber-800">Products</a>
    <span class="mx-2">/</span>
    <span>{{ Str::limit($product->title, 30) }}</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Action Buttons -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">View product details and information</p>
        </div>
        <div class="flex items-center space-x-2">
            @can('edit products')
            <a href="{{ route('admin.products.edit', $product) }}"
               class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Product
            </a>
            @endcan
        </div>
    </div>

    <!-- Product Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Product Image -->
            @if($product->primary_image)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Image</h3>
                <img src="{{ asset('storage/' . $product->primary_image) }}"
                     alt="{{ $product->title }}"
                     class="w-full max-w-lg rounded-lg border border-gray-300">
            </div>
            @endif

            <!-- Product Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Information</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $product->title }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">SKU</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->sku }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Slug</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->slug }}</p>
                        </div>
                    </div>

                    @if($product->group)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Group</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $product->group }}</p>
                    </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Category</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $product->category->name }}</p>
                    </div>

                    @if($product->about)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">About</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $product->about }}</p>
                    </div>
                    @endif

                    @if($product->description)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <div class="mt-1 text-sm text-gray-900 prose prose-sm max-w-none">
                            {!! $product->description !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Pricing & Inventory -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Pricing & Inventory</h3>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Price</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900">${{ number_format($product->price, 2) }}</p>
                    </div>

                    @if($product->sale_price)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sale Price</label>
                        <p class="mt-1 text-lg font-semibold text-red-600">${{ number_format($product->sale_price, 2) }}</p>
                        @if($product->sale_price < $product->price)
                        <p class="mt-1 text-xs text-gray-500">
                            Save ${{ number_format($product->price - $product->sale_price, 2) }}
                        </p>
                        @endif
                    </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stock Quantity</label>
                        <p class="mt-1 text-lg font-semibold {{ $product->qty == 0 ? 'text-red-600' : ($product->qty < 10 ? 'text-yellow-600' : 'text-green-600') }}">
                            {{ $product->qty }}
                        </p>
                        @if($product->qty == 0)
                        <p class="mt-1 text-xs text-red-600">Out of Stock</p>
                        @elseif($product->qty < 10)
                        <p class="mt-1 text-xs text-yellow-600">Low Stock</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- SEO Information -->
            @if($product->meta_title || $product->meta_description)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">SEO Information</h3>

                <div class="space-y-4">
                    @if($product->meta_title)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Meta Title</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $product->meta_title }}</p>
                    </div>
                    @endif

                    @if($product->meta_description)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Meta Description</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $product->meta_description }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Availability</label>
                        @if($product->status === 'available')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Available
                        </span>
                        @elseif($product->status === 'out_of_stock')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            Out of Stock
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Discontinued
                        </span>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Created</label>
                        <p class="text-sm text-gray-900">{{ $product->created_at->format('M d, Y h:i A') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Updated</label>
                        <p class="text-sm text-gray-900">{{ $product->updated_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Stats</h3>

                <div class="space-y-3">
                    @if($product->sale_price && $product->sale_price < $product->price)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Discount</span>
                        <span class="text-sm font-semibold text-green-600">
                            {{ number_format((($product->price - $product->sale_price) / $product->price) * 100, 0) }}% OFF
                        </span>
                    </div>
                    @endif

                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Stock Value</span>
                        <span class="text-sm font-semibold text-gray-900">
                            ${{ number_format(($product->sale_price ?? $product->price) * $product->qty, 2) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>

                <div class="space-y-2">
                    @can('edit products')
                    <a href="{{ route('admin.products.edit', $product) }}"
                       class="block w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-center">
                        Edit Product
                    </a>
                    @endcan

                    @can('delete products')
                    <form action="{{ route('admin.products.destroy', $product) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="block w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            Delete Product
                        </button>
                    </form>
                    @endcan

                    <a href="{{ route('admin.products.index') }}"
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-center">
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
