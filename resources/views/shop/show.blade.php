@extends('layouts.public')

@section('title', $product->title)

@section('description')
{{ $product->description ? Str::limit(strip_tags($product->description), 160) : $product->title }}
@endsection

@section('content')

    <section class="py-20">
        <div class="container mx-auto px-4">
            <nav class="text-sm text-slate-600 mb-8">
                <a href="{{ route('home') }}" class="hover:text-amber-900">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('shop.index') }}" class="hover:text-amber-900">Shop</a>
                <span class="mx-2">/</span>
                <span class="text-slate-900">{{ $product->title }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Product Images -->
                <div>
                    <div class="aspect-square bg-slate-100 rounded-xl overflow-hidden mb-4">
                        @if($product->primary_image)
                            <img src="{{ Storage::url($product->primary_image) }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-amber-900 to-emerald-900"></div>
                        @endif
                    </div>

                    @if($product->images && $product->images->count() > 0)
                        <div class="grid grid-cols-4 gap-4">
                            @foreach($product->images->take(4) as $image)
                                <div class="aspect-square bg-slate-100 rounded-lg overflow-hidden cursor-pointer hover:opacity-75 transition">
                                    <img src="{{ Storage::url($image->image_path) }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div>
                    @if($product->category)
                        <p class="text-sm text-slate-600 mb-2">{{ $product->category->name }}</p>
                    @endif

                    <h1 class="text-4xl font-bold text-slate-900 mb-4">{{ $product->title }}</h1>

                    <div class="flex items-baseline gap-4 mb-6">
                        @if($product->sale_price && $product->sale_price < $product->price)
                            <span class="text-4xl font-bold text-red-600">LKR {{ number_format($product->sale_price, 2) }}</span>
                            <span class="text-2xl text-slate-400 line-through">LKR {{ number_format($product->price, 2) }}</span>
                        @else
                            <span class="text-4xl font-bold text-amber-900">LKR {{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>

                    <!-- Stock Status -->
                    @if($product->qty > 0)
                        <div class="flex items-center text-emerald-900 mb-6">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-semibold">In Stock ({{ $product->qty }} units)</span>
                        </div>
                    @else
                        <div class="flex items-center text-red-800 mb-6">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-semibold">Out of Stock</span>
                        </div>
                    @endif

                    @if($product->description)
                        <div class="prose max-w-none mb-8">
                            {!! $product->description !!}
                        </div>
                    @endif

                    <div class="space-y-4">
                        <x-button-primary href="{{ route('contact') }}" class="w-full justify-center text-lg">
                            Contact to Order
                        </x-button-primary>
                        <p class="text-sm text-slate-500 text-center">Get in touch to place your order</p>
                    </div>
                </div>
            </div>

            @if($relatedProducts->count() > 0)
                <div class="mt-20">
                    <h2 class="text-3xl font-bold text-slate-900 mb-8">Related Products</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $related)
                            <a href="{{ route('shop.show', $related->slug) }}" class="group">
                                <div class="aspect-square bg-slate-100 rounded-lg overflow-hidden mb-3">
                                    @if($related->primary_image)
                                        <img src="{{ Storage::url($related->primary_image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-amber-900 to-emerald-900"></div>
                                    @endif
                                </div>
                                <h3 class="font-semibold text-slate-900 group-hover:text-amber-900 mb-1">{{ $related->title }}</h3>
                                <div class="flex items-baseline gap-2">
                                    @if($related->sale_price && $related->sale_price < $related->price)
                                        <p class="text-red-600 font-bold">LKR {{ number_format($related->sale_price, 2) }}</p>
                                        <p class="text-sm text-slate-400 line-through">LKR {{ number_format($related->price, 2) }}</p>
                                    @else
                                        <p class="text-amber-900 font-bold">LKR {{ number_format($related->price, 2) }}</p>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
