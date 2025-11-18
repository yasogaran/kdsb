@extends('layouts.public')

@section('title', 'Scout Gear & Merchandise')
@section('description', 'Browse our selection of official scout uniforms, badges, camping gear, and accessories.')

@section('content')

    <!-- Hero Banner -->
    <section class="relative bg-gradient-to-br from-amber-900 to-emerald-900 py-16">
        <div class="container mx-auto px-4 text-center text-white">
            <h1 class="text-5xl md:text-6xl font-extrabold mb-4">Scout Gear & Merchandise</h1>
            <p class="text-xl">Everything you need for your scouting journey</p>
        </div>
    </section>

    <!-- Shop Layout -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar Filters -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow p-6 sticky top-24">
                        <h3 class="font-bold text-lg mb-4">Filters</h3>

                        <!-- Categories -->
                        @if($categories->count() > 0)
                            <div class="mb-6">
                                <h4 class="font-semibold text-sm text-slate-700 mb-3">Categories</h4>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" class="rounded text-amber-900" {{ !request('category') ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm">All Products</span>
                                    </label>
                                    @foreach($categories as $category)
                                        <label class="flex items-center">
                                            <input type="checkbox" class="rounded text-amber-900" {{ request('category') == $category ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm">{{ $category }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Stock Status -->
                        <div>
                            <h4 class="font-semibold text-sm text-slate-700 mb-3">Stock Status</h4>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded text-amber-900" {{ request('in_stock') ? 'checked' : '' }}>
                                <span class="ml-2 text-sm">In Stock Only</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="lg:col-span-3">
                    <div class="flex justify-between items-center mb-6">
                        <p class="text-slate-600">{{ $products->total() }} products found</p>
                        <select class="px-4 py-2 border border-slate-300 rounded-md" onchange="window.location.href='?sort=' + this.value">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name: A-Z</option>
                        </select>
                    </div>

                    @if($products->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($products as $product)
                                <div class="group bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300">
                                    <a href="{{ route('shop.show', $product->slug) }}" class="block relative aspect-square overflow-hidden bg-slate-100">
                                        @if($product->images && is_array($product->images) && count($product->images) > 0)
                                            <img src="{{ Storage::url($product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-amber-900 to-emerald-900"></div>
                                        @endif

                                        <!-- Stock Badge -->
                                        @if($product->stock > 0)
                                            <x-badge type="success" class="absolute top-2 left-2">In Stock</x-badge>
                                        @else
                                            <x-badge type="error" class="absolute top-2 left-2">Out of Stock</x-badge>
                                        @endif
                                    </a>

                                    <div class="p-4">
                                        @if($product->category)
                                            <p class="text-xs text-slate-500 mb-2">{{ $product->category }}</p>
                                        @endif
                                        <h3 class="font-semibold text-slate-900 mb-2 group-hover:text-amber-900 transition">
                                            <a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a>
                                        </h3>
                                        <div class="flex items-baseline gap-2 mb-3">
                                            <span class="text-2xl font-bold text-amber-900">LKR {{ number_format($product->price, 2) }}</span>
                                        </div>
                                        <a href="{{ route('shop.show', $product->slug) }}" class="w-full block text-center px-4 py-2 bg-amber-900 text-white rounded-md hover:bg-amber-800 transition">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-12">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-slate-500 text-lg">No products found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
