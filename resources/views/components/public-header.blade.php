<header x-data="{ mobileMenuOpen: false, aboutDropdown: false, sectionsDropdown: false, resourcesDropdown: false }" class="bg-white shadow-sm sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <x-application-logo class="h-14 w-auto" />
                    <div class="hidden md:block">
                        <div class="text-lg font-bold text-slate-900">Kandy District</div>
                        <div class="text-sm text-slate-600">Scout Branch</div>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-slate-700 hover:text-amber-900 font-medium transition {{ request()->routeIs('home') ? 'text-amber-900' : '' }}">
                    Home
                </a>

                <!-- About Us Dropdown -->
                <div class="relative" @mouseenter="aboutDropdown = true" @mouseleave="aboutDropdown = false">
                    <button class="flex items-center text-slate-700 hover:text-amber-900 font-medium transition {{ request()->routeIs('about.*') ? 'text-amber-900' : '' }}">
                        About Us
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="aboutDropdown"
                         x-transition
                         class="absolute top-full left-0 mt-2 w-56 bg-white rounded-lg shadow-lg py-2">
                        <a href="{{ route('about.index') }}" class="block px-4 py-2 text-slate-700 hover:bg-amber-50 hover:text-amber-900 transition">Our History</a>
                        <a href="{{ route('about.vision') }}" class="block px-4 py-2 text-slate-700 hover:bg-amber-50 hover:text-amber-900 transition">Vision & Mission</a>
                        <a href="{{ route('about.team') }}" class="block px-4 py-2 text-slate-700 hover:bg-amber-50 hover:text-amber-900 transition">Leadership Team</a>
                    </div>
                </div>

                <!-- Scout Sections Dropdown -->
                <div class="relative" @mouseenter="sectionsDropdown = true" @mouseleave="sectionsDropdown = false">
                    <button class="flex items-center text-slate-700 hover:text-amber-900 font-medium transition {{ request()->routeIs('sections.*') ? 'text-amber-900' : '' }}">
                        Scout Sections
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="sectionsDropdown"
                         x-transition
                         class="absolute top-full left-0 mt-2 w-56 bg-white rounded-lg shadow-lg py-2">
                        <a href="{{ route('sections.show', 'singithi') }}" class="block px-4 py-2 text-slate-700 hover:bg-amber-50 hover:text-amber-900 transition">Singithi (Ages 3-5)</a>
                        <a href="{{ route('sections.show', 'cubs') }}" class="block px-4 py-2 text-slate-700 hover:bg-amber-50 hover:text-amber-900 transition">Cubs (Ages 6-10)</a>
                        <a href="{{ route('sections.show', 'scouts') }}" class="block px-4 py-2 text-slate-700 hover:bg-amber-50 hover:text-amber-900 transition">Scouts (Ages 11-15)</a>
                        <a href="{{ route('sections.show', 'senior-scouts') }}" class="block px-4 py-2 text-slate-700 hover:bg-amber-50 hover:text-amber-900 transition">Senior Scouts (Ages 16-18)</a>
                        <a href="{{ route('sections.show', 'rovers') }}" class="block px-4 py-2 text-slate-700 hover:bg-amber-50 hover:text-amber-900 transition">Rovers (Ages 18-25)</a>
                        <a href="{{ route('sections.show', 'masters') }}" class="block px-4 py-2 text-slate-700 hover:bg-amber-50 hover:text-amber-900 transition">Scout Masters (Adult Leaders)</a>
                    </div>
                </div>

                <a href="{{ route('events.index') }}" class="text-slate-700 hover:text-amber-900 font-medium transition {{ request()->routeIs('events.*') ? 'text-amber-900' : '' }}">
                    Events
                </a>

                <a href="{{ route('news.index') }}" class="text-slate-700 hover:text-amber-900 font-medium transition {{ request()->routeIs('news.*') ? 'text-amber-900' : '' }}">
                    News
                </a>

                <a href="{{ route('gallery.index') }}" class="text-slate-700 hover:text-amber-900 font-medium transition {{ request()->routeIs('gallery.*') ? 'text-amber-900' : '' }}">
                    Gallery
                </a>

                <!-- Resources Dropdown -->
                <div class="relative" @mouseenter="resourcesDropdown = true" @mouseleave="resourcesDropdown = false">
                    <button class="flex items-center text-slate-700 hover:text-amber-900 font-medium transition {{ request()->routeIs('resources.*') ? 'text-amber-900' : '' }}">
                        Resources
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="resourcesDropdown"
                         x-transition
                         class="absolute top-full left-0 mt-2 w-56 bg-white rounded-lg shadow-lg py-2">
                        <a href="{{ route('resources.circulars') }}" class="block px-4 py-2 text-slate-700 hover:bg-amber-50 hover:text-amber-900 transition">Circulars</a>
                        <a href="{{ route('resources.syllabus') }}" class="block px-4 py-2 text-slate-700 hover:bg-amber-50 hover:text-amber-900 transition">Syllabus & Training</a>
                    </div>
                </div>

                <a href="{{ route('shop.index') }}" class="text-slate-700 hover:text-amber-900 font-medium transition {{ request()->routeIs('shop.*') ? 'text-amber-900' : '' }}">
                    Shop
                </a>
            </nav>

            <!-- Contact Button & Mobile Menu Toggle -->
            <div class="flex items-center space-x-4">
                <x-button-primary href="{{ route('contact') }}" class="hidden lg:inline-flex">
                    Contact Us
                </x-button-primary>

                <!-- Mobile Menu Toggle -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-slate-700">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen"
             x-transition
             class="lg:hidden py-4 border-t border-slate-200">
            <nav class="flex flex-col space-y-2">
                <a href="{{ route('home') }}" class="px-4 py-2 text-slate-700 hover:bg-amber-50 hover:text-amber-900 rounded transition">Home</a>

                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2 text-slate-700 hover:bg-amber-50 hover:text-amber-900 rounded transition">
                        <span>About Us</span>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" class="pl-4 space-y-1">
                        <a href="{{ route('about.index') }}" class="block px-4 py-2 text-sm text-slate-600 hover:text-amber-900">Our History</a>
                        <a href="{{ route('about.vision') }}" class="block px-4 py-2 text-sm text-slate-600 hover:text-amber-900">Vision & Mission</a>
                        <a href="{{ route('about.team') }}" class="block px-4 py-2 text-sm text-slate-600 hover:text-amber-900">Leadership Team</a>
                    </div>
                </div>

                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2 text-slate-700 hover:bg-amber-50 hover:text-amber-900 rounded transition">
                        <span>Scout Sections</span>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" class="pl-4 space-y-1">
                        <a href="{{ route('sections.show', 'singithi') }}" class="block px-4 py-2 text-sm text-slate-600 hover:text-amber-900">Singithi</a>
                        <a href="{{ route('sections.show', 'cubs') }}" class="block px-4 py-2 text-sm text-slate-600 hover:text-amber-900">Cubs</a>
                        <a href="{{ route('sections.show', 'scouts') }}" class="block px-4 py-2 text-sm text-slate-600 hover:text-amber-900">Scouts</a>
                        <a href="{{ route('sections.show', 'senior-scouts') }}" class="block px-4 py-2 text-sm text-slate-600 hover:text-amber-900">Senior Scouts</a>
                        <a href="{{ route('sections.show', 'rovers') }}" class="block px-4 py-2 text-sm text-slate-600 hover:text-amber-900">Rovers</a>
                        <a href="{{ route('sections.show', 'masters') }}" class="block px-4 py-2 text-sm text-slate-600 hover:text-amber-900">Scout Masters</a>
                    </div>
                </div>

                <a href="{{ route('events.index') }}" class="px-4 py-2 text-slate-700 hover:bg-amber-50 hover:text-amber-900 rounded transition">Events</a>
                <a href="{{ route('news.index') }}" class="px-4 py-2 text-slate-700 hover:bg-amber-50 hover:text-amber-900 rounded transition">News</a>
                <a href="{{ route('gallery.index') }}" class="px-4 py-2 text-slate-700 hover:bg-amber-50 hover:text-amber-900 rounded transition">Gallery</a>

                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2 text-slate-700 hover:bg-amber-50 hover:text-amber-900 rounded transition">
                        <span>Resources</span>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" class="pl-4 space-y-1">
                        <a href="{{ route('resources.circulars') }}" class="block px-4 py-2 text-sm text-slate-600 hover:text-amber-900">Circulars</a>
                        <a href="{{ route('resources.syllabus') }}" class="block px-4 py-2 text-sm text-slate-600 hover:text-amber-900">Syllabus & Training</a>
                    </div>
                </div>

                <a href="{{ route('shop.index') }}" class="px-4 py-2 text-slate-700 hover:bg-amber-50 hover:text-amber-900 rounded transition">Shop</a>
                <a href="{{ route('contact') }}" class="px-4 py-2 bg-amber-900 text-white rounded font-semibold hover:bg-amber-800 transition">Contact Us</a>
            </nav>
        </div>
    </div>
</header>
