@extends('layouts.public')

@section('title', 'Official Circulars')
@section('description', 'Access important announcements and official documents from Kandy District Scout Branch.')

@section('content')

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-amber-900 to-emerald-900 py-20">
        <div class="container mx-auto px-4">
            <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-4">Official Circulars</h1>
            <p class="text-xl text-white/90 max-w-2xl">Important announcements and documents</p>
        </div>
    </section>

    <!-- Filters -->
    <section class="py-8 bg-white shadow-sm">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap gap-4">
                <select class="px-4 py-2 border border-slate-300 rounded-md" onchange="window.location.href='?year=' + this.value">
                    <option value="">All Years</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>

                @if($categories->count() > 0)
                    <select class="px-4 py-2 border border-slate-300 rounded-md" onchange="window.location.href='?category=' + this.value">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>
    </section>

    <!-- Circulars Table -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            @if($circulars->count() > 0)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Ref No.</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @foreach($circulars as $circular)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                        {{ $circular->published_date ? $circular->published_date->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                        {{ $circular->circular_number }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-900">
                                        {{ $circular->title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($circular->file_path)
                                            <a href="{{ Storage::url($circular->file_path) }}" target="_blank" class="text-amber-900 hover:text-amber-800 font-medium">
                                                Download
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-8">
                    {{ $circulars->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-slate-500">No circulars found.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
