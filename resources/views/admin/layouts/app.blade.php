<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') - {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased bg-neutral">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-primary text-white flex-shrink-0">
            <div class="p-6">
                <h2 class="text-2xl font-bold">{{ config('app.name') }}</h2>
                <p class="text-sm text-amber-200">Admin Panel</p>
            </div>

            <nav class="mt-6">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center px-6 py-3 hover:bg-amber-800 {{ request()->routeIs('admin.dashboard') ? 'bg-amber-800 border-l-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>

                @canany(['view posts', 'view categories', 'view events', 'view galleries', 'view syllabus', 'view circulars'])
                <!-- Content Management -->
                <div class="mt-4">
                    <p class="px-6 py-2 text-xs font-semibold text-amber-200 uppercase">Content</p>

                    @can('view categories')
                    <a href="{{ route('admin.categories.index') }}"
                       class="flex items-center px-6 py-3 hover:bg-amber-800 {{ request()->routeIs('admin.categories.*') ? 'bg-amber-800 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Categories
                    </a>
                    @endcan

                    @can('view posts')
                    <a href="{{ route('admin.posts.index') }}"
                       class="flex items-center px-6 py-3 hover:bg-amber-800 {{ request()->routeIs('admin.posts.*') ? 'bg-amber-800 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        Posts
                    </a>
                    @endcan

                    @can('view events')
                    <a href="{{ route('admin.events.index') }}"
                       class="flex items-center px-6 py-3 hover:bg-amber-800 {{ request()->routeIs('admin.events.*') ? 'bg-amber-800 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Events
                    </a>
                    @endcan

                    @can('view galleries')
                    <a href="{{ route('admin.galleries.index') }}"
                       class="flex items-center px-6 py-3 hover:bg-amber-800 {{ request()->routeIs('admin.galleries.*') ? 'bg-amber-800 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Galleries
                    </a>
                    @endcan
                </div>
                @endcanany

                @canany(['view syllabus', 'view circulars'])
                <!-- Resources -->
                <div class="mt-4">
                    <p class="px-6 py-2 text-xs font-semibold text-amber-200 uppercase">Resources</p>

                    @can('view syllabus')
                    <a href="{{ route('admin.syllabi.index') }}"
                       class="flex items-center px-6 py-3 hover:bg-amber-800 {{ request()->routeIs('admin.syllabi.*') ? 'bg-amber-800 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Syllabus
                    </a>
                    @endcan

                    @can('view circulars')
                    <a href="{{ route('admin.circulars.index') }}"
                       class="flex items-center px-6 py-3 hover:bg-amber-800 {{ request()->routeIs('admin.circulars.*') ? 'bg-amber-800 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Circulars
                    </a>
                    @endcan
                </div>
                @endcanany

                @canany(['view products', 'view product-categories'])
                <!-- Shop -->
                <div class="mt-4">
                    <p class="px-6 py-2 text-xs font-semibold text-amber-200 uppercase">Shop</p>

                    @can('view product-categories')
                    <a href="{{ route('admin.product-categories.index') }}"
                       class="flex items-center px-6 py-3 hover:bg-amber-800 {{ request()->routeIs('admin.product-categories.*') ? 'bg-amber-800 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Product Categories
                    </a>
                    @endcan

                    @can('view products')
                    <a href="{{ route('admin.products.index') }}"
                       class="flex items-center px-6 py-3 hover:bg-amber-800 {{ request()->routeIs('admin.products.*') ? 'bg-amber-800 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Products
                    </a>
                    @endcan
                </div>
                @endcanany

                @canany(['view settings', 'view milestones'])
                <!-- Settings -->
                <div class="mt-4">
                    <p class="px-6 py-2 text-xs font-semibold text-amber-200 uppercase">Site Management</p>

                    @can('view settings')
                    <a href="{{ route('admin.settings.index') }}"
                       class="flex items-center px-6 py-3 hover:bg-amber-800 {{ request()->routeIs('admin.settings.*') ? 'bg-amber-800 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Settings
                    </a>
                    @endcan

                    @can('view milestones')
                    <a href="{{ route('admin.milestones.index') }}"
                       class="flex items-center px-6 py-3 hover:bg-amber-800 {{ request()->routeIs('admin.milestones.*') ? 'bg-amber-800 border-l-4 border-white' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Milestones
                    </a>
                    @endcan
                </div>
                @endcanany

                <!-- Back to Site -->
                <div class="mt-4 border-t border-amber-700 pt-4">
                    <a href="{{ route('home') }}"
                       class="flex items-center px-6 py-3 hover:bg-amber-800">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Site
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                        @hasSection('breadcrumbs')
                            <nav class="text-sm text-gray-600 mt-1">
                                @yield('breadcrumbs')
                            </nav>
                        @endif
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-accent hover:text-red-700">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-neutral p-6">
                <!-- Success/Error Messages -->
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Whoops! Something went wrong.</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
