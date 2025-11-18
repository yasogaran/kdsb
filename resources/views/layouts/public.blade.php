<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- SEO Meta Tags -->
        <title>@yield('title', 'Kandy District Scout Branch') | Kandy Scouts</title>
        <meta name="description" content="@yield('description', 'Building tomorrow\'s leaders through adventure, service, and character development since 1912.')">
        <meta name="keywords" content="scouts, kandy scouts, sri lanka scouts, scouting, youth development, leadership">

        <!-- Open Graph Meta Tags -->
        <meta property="og:title" content="@yield('title', 'Kandy District Scout Branch')">
        <meta property="og:description" content="@yield('description', 'Building tomorrow\'s leaders through adventure, service, and character development since 1912.')">
        <meta property="og:image" content="@yield('ogImage', asset('images/og-default.jpg'))">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="Kandy District Scout Branch">

        <!-- Twitter Card Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="@yield('title', 'Kandy District Scout Branch')">
        <meta name="twitter:description" content="@yield('description', 'Building tomorrow\'s leaders through adventure, service, and character development since 1912.')">
        <meta name="twitter:image" content="@yield('ogImage', asset('images/og-default.jpg'))">

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Additional Styles -->
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-slate-50">
        <!-- Header -->
        <x-public-header />

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <x-public-footer :settings="$settings ?? []" />

        <!-- Additional Scripts -->
        @stack('scripts')

        <!-- Scroll to Top Button -->
        <div x-data="{ showScrollTop: false }"
             @scroll.window="showScrollTop = window.pageYOffset > 300"
             class="fixed bottom-8 right-8 z-40">
            <button x-show="showScrollTop"
                    x-transition
                    @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                    class="bg-amber-900 text-white p-3 rounded-full shadow-lg hover:bg-amber-800 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                </svg>
            </button>
        </div>

        <!-- Structured Data (Schema.org) -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "Kandy District Scout Branch",
            "url": "{{ url('/') }}",
            "logo": "{{ asset('images/logo.png') }}",
            "description": "Building tomorrow's leaders through adventure, service, and character development since 1912.",
            "address": {
                "@type": "PostalAddress",
                "addressLocality": "Kandy",
                "addressCountry": "LK"
            },
            "sameAs": [
                "{{ $settings['facebook_url'] ?? '' }}",
                "{{ $settings['twitter_url'] ?? '' }}",
                "{{ $settings['youtube_url'] ?? '' }}",
                "{{ $settings['instagram_url'] ?? '' }}"
            ]
        }
        </script>

        @stack('structured-data')
    </body>
</html>
