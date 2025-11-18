@extends('admin.layouts.app')

@section('title', 'View Product Category')
@section('page-title', $category->name)

@section('breadcrumbs')
    <a href="{{ route('admin.product-categories.index') }}" class="text-primary hover:text-amber-800">Product Categories</a>
    <span class="mx-2">/</span>
    <span>{{ Str::limit($category->name, 30) }}</span>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Action Buttons -->
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-600">View category details and products</p>
        </div>
        <div class="flex items-center space-x-2">
            @can('edit product-categories')
            <a href="{{ route('admin.product-categories.edit', $category) }}"
               class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-amber-800 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Category
            </a>
            @endcan
        </div>
    </div>

    <!-- Category Details -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Category Image -->
            @if($category->image)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Category Image</h3>
                <img src="{{ asset('storage/' . $category->image) }}"
                     alt="{{ $category->name }}"
                     class="w-full max-w-md rounded-lg border border-gray-300">
            </div>
            @endif

            <!-- Category Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Category Information</h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $category->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Slug</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $category->slug }}</p>
                    </div>

                    @if($category->description)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $category->description }}</p>
                    </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sort Order</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $category->sort_order }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Total Products</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $category->products_count ?? 0 }} products</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Details</h3>

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Created</label>
                        <p class="text-sm text-gray-900">{{ $category->created_at->format('M d, Y h:i A') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Updated</label>
                        <p class="text-sm text-gray-900">{{ $category->updated_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>

                <div class="space-y-2">
                    @can('edit product-categories')
                    <a href="{{ route('admin.product-categories.edit', $category) }}"
                       class="block w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-center">
                        Edit Category
                    </a>
                    @endcan

                    @can('delete product-categories')
                    <form action="{{ route('admin.product-categories.destroy', $category) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="block w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            Delete Category
                        </button>
                    </form>
                    @endcan

                    <a href="{{ route('admin.product-categories.index') }}"
                       class="block w-full px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-center">
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
