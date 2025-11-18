<x-layouts.public>
    <x-slot name="title">{{ $sectionData['name'] }}</x-slot>
    <x-slot name="description">{{ $sectionData['description'] }}</x-slot>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-amber-900 to-emerald-900 py-20">
        <div class="container mx-auto px-4">
            <nav class="text-sm text-white/80 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('sections.index') }}" class="hover:text-white">Sections</a>
                <span class="mx-2">/</span>
                <span class="text-white">{{ $sectionData['name'] }}</span>
            </nav>
            <div class="flex items-center gap-6">
                <div class="w-24 h-24 rounded-full bg-white/20 flex items-center justify-center text-white text-5xl font-bold">
                    {{ substr($sectionData['name'], 0, 1) }}
                </div>
                <div>
                    <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-2">{{ $sectionData['name'] }}</h1>
                    <p class="text-2xl text-white/90">{{ $sectionData['age_range'] }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-20">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="prose prose-lg max-w-none">
                <h2>About {{ $sectionData['name'] }}</h2>
                <p>{{ $sectionData['description'] }}</p>

                <h3>What You'll Learn</h3>
                <ul>
                    <li>Leadership and teamwork skills</li>
                    <li>Outdoor survival and camping</li>
                    <li>Community service and citizenship</li>
                    <li>Personal development and character building</li>
                </ul>

                <h3>How to Join</h3>
                <p>Interested in joining the {{ $sectionData['name'] }} section? Contact your nearest scout group or get in touch with us through our <a href="{{ route('contact') }}">contact page</a>.</p>
            </div>

            <div class="mt-12 text-center">
                <x-button-primary href="{{ route('contact') }}">Contact Us to Join</x-button-primary>
            </div>
        </div>
    </section>
</x-layouts.public>
