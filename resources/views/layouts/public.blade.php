<!DOCTYPE html>
<html lang="en" x-data="{
    darkMode: localStorage.getItem('theme') === 'dark',
    mobileMenu: false
}" :class="{ 'dark': darkMode }" x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="min-h-screen bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 transition-colors duration-200">

    {{-- ── Navbar ──────────────────────────────────────────────── --}}
    <nav class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-2 flex-shrink-0">
                    <div class="w-8 h-8 bg-brand-600 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16
                                 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0
                                 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-lg font-bold text-gray-900 dark:text-white">
                        Jobs<span class="text-brand-600">Nepal</span>
                    </span>
                </a>

                {{-- Desktop nav --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('jobs.index') }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium
                          text-gray-600 dark:text-gray-400
                          hover:bg-gray-100 dark:hover:bg-gray-800
                          hover:text-gray-900 dark:hover:text-white transition-colors
                          {{ request()->routeIs('jobs.*') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white' : '' }}">
                        Browse Jobs
                    </a>
                    <a href="{{ route('companies.index') }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium
                          text-gray-600 dark:text-gray-400
                          hover:bg-gray-100 dark:hover:bg-gray-800
                          hover:text-gray-900 dark:hover:text-white transition-colors
                          {{ request()->routeIs('companies.*') ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white' : '' }}">
                        Companies
                    </a>
                    <a href="{{ route('pricing') }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium
                          text-gray-600 dark:text-gray-400
                          hover:bg-gray-100 dark:hover:bg-gray-800
                          hover:text-gray-900 dark:hover:text-white transition-colors">
                        Pricing
                    </a>
                </div>

                {{-- Right actions --}}
                <div class="flex items-center gap-2">

                    {{-- Dark mode toggle --}}
                    <button @click="darkMode = !darkMode"
                        class="p-2 rounded-lg text-gray-500 dark:text-gray-400
                               hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0
                                 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343
                                 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16
                                 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>

                    @auth
                        {{-- User dropdown --}}
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.away="open = false"
                                class="flex items-center gap-2 px-2 py-1.5 rounded-lg
               hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                @if (auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatarUrl() }}" alt="{{ auth()->user()->name }}"
                                        class="w-7 h-7 rounded-full object-cover border border-gray-200 dark:border-gray-700">
                                @else
                                    <div
                                        class="w-7 h-7 rounded-full bg-brand-100 dark:bg-brand-900
                    flex items-center justify-center
                    text-brand-700 dark:text-brand-300 text-xs font-bold">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span
                                    class="hidden sm:block text-sm font-medium
                 text-gray-700 dark:text-gray-300 max-w-[100px] truncate">
                                    {{ auth()->user()->name }}
                                </span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-900
                                    rounded-xl border border-gray-200 dark:border-gray-700
                                    shadow-lg py-1 z-50">

                                <div class="px-4 py-2.5 border-b border-gray-100 dark:border-gray-800">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                        {{ auth()->user()->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                        {{ auth()->user()->email }}
                                    </p>
                                    <span
                                        class="inline-block mt-1 text-xs px-2 py-0.5 rounded-full
                                             bg-brand-100 dark:bg-brand-900
                                             text-brand-700 dark:text-brand-300">
                                        {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}
                                    </span>
                                </div>

                                @if (auth()->user()->isCompanyMember())
                                    <a href="{{ route('company.dashboard') }}"
                                        class="flex items-center gap-2 px-4 py-2 text-sm
                                          text-gray-700 dark:text-gray-300
                                          hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0
                                                             00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                        </svg>
                                        Company Dashboard
                                    </a>
                                @elseif(auth()->user()->isSeeker())
                                    <a href="{{ route('seeker.dashboard') }}"
                                        class="flex items-center gap-2 px-4 py-2 text-sm
                                          text-gray-700 dark:text-gray-300
                                          hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        My Dashboard
                                    </a>
                                @elseif(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="flex items-center gap-2 px-4 py-2 text-sm
                                          text-gray-700 dark:text-gray-300
                                          hover:bg-gray-50 dark:hover:bg-gray-800">
                                        Admin Panel
                                    </a>
                                @endif

                                <div class="border-t border-gray-100 dark:border-gray-800 mt-1 pt-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center gap-2 w-full px-4 py-2 text-sm
                                                   text-red-600 dark:text-red-400
                                                   hover:bg-red-50 dark:hover:bg-red-900/20">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3
                                                                 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Sign out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn-secondary hidden sm:inline-flex text-sm px-3 py-2">
                            Sign in
                        </a>
                        <a href="{{ route('register.company') }}" class="btn-primary text-sm px-3 py-2">
                            Post a Job
                        </a>
                    @endauth

                    {{-- Mobile menu button --}}
                    <button @click="mobileMenu = !mobileMenu"
                        class="md:hidden p-2 rounded-lg text-gray-500
                               hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <svg x-show="!mobileMenu" class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileMenu" class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileMenu" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            class="md:hidden border-t border-gray-200 dark:border-gray-800
                bg-white dark:bg-gray-900 px-4 py-3 space-y-1">
            <a href="{{ route('jobs.index') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium
                  text-gray-700 dark:text-gray-300
                  hover:bg-gray-100 dark:hover:bg-gray-800">Browse
                Jobs</a>
            <a href="{{ route('companies.index') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium
                  text-gray-700 dark:text-gray-300
                  hover:bg-gray-100 dark:hover:bg-gray-800">Companies</a>
            <a href="{{ route('pricing') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium
                  text-gray-700 dark:text-gray-300
                  hover:bg-gray-100 dark:hover:bg-gray-800">Pricing</a>
            @guest
                <div class="pt-2 border-t border-gray-100 dark:border-gray-800 flex gap-2">
                    <a href="{{ route('login') }}" class="btn-secondary flex-1 justify-center text-sm">Sign in</a>
                    <a href="{{ route('register') }}" class="btn-primary flex-1 justify-center text-sm">Register</a>
                </div>
            @endguest
        </div>
    </nav>

    {{-- ── Flash Messages ──────────────────────────────────────── --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="fixed top-20 right-4 z-50 max-w-sm w-full
                bg-green-50 dark:bg-green-900/50
                border border-green-200 dark:border-green-700
                text-green-800 dark:text-green-200
                px-4 py-3 rounded-xl shadow-lg">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0
                         00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414
                         1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
                <button @click="show = false" class="ml-auto text-green-600 dark:text-green-400 hover:text-green-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed top-20 right-4 z-50 max-w-sm w-full
                bg-red-50 dark:bg-red-900/50
                border border-red-200 dark:border-red-700
                text-red-800 dark:text-red-200
                px-4 py-3 rounded-xl shadow-lg">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0
                         00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414
                         1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414
                         10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <p class="text-sm font-medium">{{ session('error') }}</p>
                <button @click="show = false" class="ml-auto text-red-600 hover:text-red-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    {{-- ── Main Content ─────────────────────────────────────────── --}}
    <main>@yield('content')</main>

    {{-- ── Footer ──────────────────────────────────────────────── --}}
    <footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-8">
                <div class="col-span-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 mb-4">
                        <div class="w-7 h-7 bg-brand-600 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16
                                     6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0
                                     002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <span class="font-bold text-gray-900 dark:text-white">
                            Jobs<span class="text-brand-600">Nepal</span>
                        </span>
                    </a>
                    <p class="text-sm text-gray-500 dark:text-gray-400 max-w-xs leading-relaxed">
                        Nepal's modern job portal connecting great companies with talented professionals.
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">For Job Seekers</h3>
                    <ul class="space-y-2.5 text-sm text-gray-500 dark:text-gray-400">
                        <li><a href="{{ route('jobs.index') }}" class="hover:text-brand-600 transition-colors">Browse
                                Jobs</a></li>
                        <li><a href="{{ route('register.seeker') }}"
                                class="hover:text-brand-600 transition-colors">Create Profile</a></li>
                        <li><a href="{{ route('companies.index') }}"
                                class="hover:text-brand-600 transition-colors">Companies</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">For Employers</h3>
                    <ul class="space-y-2.5 text-sm text-gray-500 dark:text-gray-400">
                        <li><a href="{{ route('register.company') }}"
                                class="hover:text-brand-600 transition-colors">Post a Job</a></li>
                        <li><a href="{{ route('pricing') }}"
                                class="hover:text-brand-600 transition-colors">Pricing</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-brand-600 transition-colors">Sign In</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div
                class="border-t border-gray-200 dark:border-gray-800 pt-6 flex flex-col sm:flex-row
                    justify-between items-center gap-3 text-sm text-gray-400 dark:text-gray-500">
                <p>&copy; {{ date('Y') }} JobsNepal. Built with passion in Nepal.</p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-brand-600 transition-colors">Privacy</a>
                    <a href="#" class="hover:text-brand-600 transition-colors">Terms</a>
                    <a href="#" class="hover:text-brand-600 transition-colors">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
