<x-layouts.public>
    <x-slot name="title">Syllabus & Training Materials</x-slot>
    <x-slot name="description">Access training materials, handbooks, and resources for all scout sections.</x-slot>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-amber-900 to-emerald-900 py-20">
        <div class="container mx-auto px-4">
            <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-4">Syllabus & Training Materials</h1>
            <p class="text-xl text-white/90 max-w-2xl">Resources for scouts and leaders</p>
        </div>
    </section>

    <!-- Materials by Section -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            @if($groupedSyllabi->count() > 0)
                @foreach($groupedSyllabi as $category => $syllabi)
                    <div class="mb-12">
                        <h2 class="text-3xl font-bold text-slate-900 mb-6">{{ $category }}</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($syllabi as $syllabus)
                                <x-card>
                                    <div class="flex items-start gap-4">
                                        <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6 text-amber-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-semibold text-slate-900 mb-2">{{ $syllabus->title }}</h3>
                                            @if($syllabus->description)
                                                <p class="text-sm text-slate-600 mb-3">{{ Str::limit($syllabus->description, 100) }}</p>
                                            @endif
                                            @if($syllabus->file_path)
                                                <a href="{{ Storage::url($syllabus->file_path) }}" target="_blank" class="inline-flex items-center text-amber-900 font-semibold text-sm hover:text-amber-800">
                                                    Download
                                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </x-card>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-12">
                    <p class="text-slate-500">Training materials coming soon.</p>
                </div>
            @endif
        </div>
    </section>
</x-layouts.public>
