<x-layouts.public>
    <x-slot name="title">Leadership Team</x-slot>
    <x-slot name="description">Meet the dedicated leaders of Kandy District Scout Branch.</x-slot>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-amber-900 to-emerald-900 py-20">
        <div class="container mx-auto px-4">
            <nav class="text-sm text-white/80 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('about.index') }}" class="hover:text-white">About</a>
                <span class="mx-2">/</span>
                <span class="text-white">Leadership Team</span>
            </nav>

            <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-4">
                Leadership Team
            </h1>
            <p class="text-xl text-white/90 max-w-2xl">
                Meet the dedicated individuals leading our organization
            </p>
        </div>
    </section>

    <!-- Commissioner Section -->
    @if(!empty($settings['commissioner_name']))
        <section class="py-20 bg-slate-50">
            <div class="container mx-auto px-4">
                <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-lg p-8 md:p-12">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @if(!empty($settings['commissioner_photo']))
                            <div class="md:col-span-1">
                                <img src="{{ Storage::url($settings['commissioner_photo']) }}" alt="{{ $settings['commissioner_name'] }}" class="w-full rounded-xl shadow-md">
                            </div>
                        @endif

                        <div class="md:col-span-2">
                            <x-badge type="warning" class="mb-3">District Commissioner</x-badge>
                            <h2 class="text-3xl font-bold text-slate-900 mb-4">{{ $settings['commissioner_name'] }}</h2>

                            @if(!empty($settings['commissioner_message']))
                                <div class="prose max-w-none text-slate-700">
                                    {!! nl2br(e($settings['commissioner_message'])) !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Team Members Placeholder -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <x-section-title label="Our Team">
                Executive Committee
            </x-section-title>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
                @php
                $teamPlaceholder = [
                    ['position' => 'Deputy Commissioner', 'name' => 'TBD'],
                    ['position' => 'Secretary', 'name' => 'TBD'],
                    ['position' => 'Treasurer', 'name' => 'TBD'],
                    ['position' => 'Program Coordinator', 'name' => 'TBD'],
                ];
                @endphp

                @foreach($teamPlaceholder as $member)
                    <x-card class="text-center">
                        <div class="w-32 h-32 mx-auto mb-4 rounded-full bg-gradient-to-br from-amber-900 to-emerald-900 flex items-center justify-center text-white text-2xl font-bold">
                            {{ substr($member['position'], 0, 1) }}
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900 mb-1">{{ $member['name'] }}</h3>
                        <p class="text-sm text-slate-600">{{ $member['position'] }}</p>
                    </x-card>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <p class="text-slate-500">Full team directory coming soon</p>
            </div>
        </div>
    </section>
</x-layouts.public>
