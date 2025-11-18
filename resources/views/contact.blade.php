<x-layouts.public>
    <x-slot name="title">Contact Us</x-slot>
    <x-slot name="description">Get in touch with Kandy District Scout Branch. We'd love to hear from you!</x-slot>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-amber-900 to-emerald-900 py-20">
        <div class="container mx-auto px-4">
            <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-4">Get in Touch</h1>
            <p class="text-xl text-white/90 max-w-2xl">We'd love to hear from you</p>
        </div>
    </section>

    <!-- Contact Form & Info -->
    <section class="py-20">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-6xl mx-auto">
                <!-- Contact Form -->
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-6">Send us a Message</h2>

                    @if(session('success'))
                        <div class="bg-emerald-50 border border-emerald-900 text-emerald-900 px-4 py-3 rounded-lg mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Name *</label>
                            <input type="text" id="name" name="name" required class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-900 focus:border-transparent">
                            @error('name')
                                <p class="text-red-800 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email *</label>
                            <input type="email" id="email" name="email" required class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-900 focus:border-transparent">
                            @error('email')
                                <p class="text-red-800 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-slate-700 mb-2">Phone</label>
                            <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-900 focus:border-transparent">
                            @error('phone')
                                <p class="text-red-800 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-slate-700 mb-2">Subject *</label>
                            <input type="text" id="subject" name="subject" required class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-900 focus:border-transparent">
                            @error('subject')
                                <p class="text-red-800 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-slate-700 mb-2">Message *</label>
                            <textarea id="message" name="message" required rows="6" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-amber-900 focus:border-transparent resize-vertical"></textarea>
                            @error('message')
                                <p class="text-red-800 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <x-button-primary type="submit" class="w-full justify-center">
                            Send Message
                        </x-button-primary>
                    </form>
                </div>

                <!-- Contact Information -->
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-6">Contact Information</h2>

                    <div class="space-y-6 mb-8">
                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-amber-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-slate-900 mb-1">Address</h3>
                                <p class="text-slate-600">{{ $settings['address'] ?? 'Scout Association, Kandy District, Sri Lanka' }}</p>
                            </div>
                        </div>

                        @if(!empty($settings['phone']))
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-emerald-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-semibold text-slate-900 mb-1">Phone</h3>
                                    <p class="text-slate-600">{{ $settings['phone'] }}</p>
                                </div>
                            </div>
                        @endif

                        @if(!empty($settings['email']))
                            <div class="flex items-start">
                                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-amber-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="font-semibold text-slate-900 mb-1">Email</h3>
                                    <p class="text-slate-600">{{ $settings['email'] }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-start">
                            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-emerald-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="font-semibold text-slate-900 mb-1">Office Hours</h3>
                                <p class="text-slate-600">Monday - Friday: 8:00 AM - 4:00 PM</p>
                                <p class="text-slate-600">Saturday: 8:00 AM - 12:00 PM</p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div>
                        <h3 class="font-semibold text-slate-900 mb-4">Follow Us</h3>
                        <div class="flex gap-3">
                            @if(!empty($settings['facebook_url']))
                                <a href="{{ $settings['facebook_url'] }}" target="_blank" class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center hover:bg-amber-900 hover:text-white transition">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                            @endif
                            @if(!empty($settings['youtube_url']))
                                <a href="{{ $settings['youtube_url'] }}" target="_blank" class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center hover:bg-amber-900 hover:text-white transition">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section (Optional) -->
    <section class="py-20 bg-slate-50">
        <div class="container mx-auto px-4">
            <div class="aspect-video bg-slate-200 rounded-xl overflow-hidden">
                <!-- Placeholder for Google Maps -->
                <div class="w-full h-full flex items-center justify-center text-slate-500">
                    <div class="text-center">
                        <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        <p>Map integration coming soon</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>
