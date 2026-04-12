<!DOCTYPE html>
<html lang="en"
      x-data="{
          darkMode: localStorage.getItem('theme') === 'dark',
          sidebarOpen: false
      }"
      :class="{ 'dark': darkMode }"
      x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="min-h-screen bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100">

<div class="flex h-screen overflow-hidden">

    {{-- ── Sidebar ─────────────────────────────────────────── --}}
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-900
                  border-r border-gray-200 dark:border-gray-800
                  transform transition-transform duration-200 ease-in-out
                  lg:translate-x-0 lg:static lg:inset-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        {{-- Logo --}}
        <div class="flex items-center justify-between h-16 px-5
                    border-b border-gray-200 dark:border-gray-800">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-brand-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 13.255A23.931 23.931 0 0112 15c-3.183
                                 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0
                                 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0
                                 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="font-bold text-gray-900 dark:text-white">
                    Jobs<span class="text-brand-600">Nepal</span>
                </span>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden p-1 rounded text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Company info --}}
        @if(auth()->user()->company)
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-800">
            <div class="flex items-center gap-3">
                <img src="{{ auth()->user()->company->logoUrl() }}"
                     alt="{{ auth()->user()->company->name }}"
                     class="w-9 h-9 rounded-lg object-cover border border-gray-200 dark:border-gray-700">
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                        {{ auth()->user()->company->name }}
                    </p>
                    @php $company = auth()->user()->company; @endphp
                    @if($company->isOnTrial())
                        <span class="text-xs text-amber-600 dark:text-amber-400">
                            Trial: {{ $company->trialDaysLeft() }} days left
                        </span>
                    @else
                        <span class="text-xs text-green-600 dark:text-green-400">
                            {{ ucfirst($company->subscription_status) }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- Navigation --}}
        <nav class="px-3 py-4 space-y-1 overflow-y-auto flex-1">

            <p class="px-3 text-xs font-semibold text-gray-400 dark:text-gray-500
                      uppercase tracking-wider mb-2">Main</p>

            <a href="{{ route('company.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('company.dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0
                             00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('company.jobs.index') }}"
               class="sidebar-link {{ request()->routeIs('company.jobs.*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16
                             6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0
                             002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Job Listings
            </a>

            <a href="{{ route('company.applications.index', ['job' => 'all']) }}"
               class="sidebar-link {{ request()->routeIs('company.applications.*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1
                             1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Applications
            </a>

            <p class="px-3 text-xs font-semibold text-gray-400 dark:text-gray-500
                      uppercase tracking-wider mb-2 mt-4">Settings</p>

            <a href="{{ route('company.team.index') }}"
               class="sidebar-link {{ request()->routeIs('company.team.*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7
                             20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002
                             5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Team
            </a>

            <a href="{{ route('company.profile.edit') }}"
               class="sidebar-link {{ request()->routeIs('company.profile.*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9
                             0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0
                             011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Company Profile
            </a>

            <a href="{{ route('company.subscription.index') }}"
               class="sidebar-link {{ request()->routeIs('company.subscription.*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3
                             3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                Subscription
            </a>
        </nav>

        {{-- Bottom: user + logout --}}
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 dark:border-gray-800
                    bg-white dark:bg-gray-900">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-brand-100 dark:bg-brand-900
                            flex items-center justify-center text-brand-700 dark:text-brand-300
                            text-sm font-bold flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-medium text-gray-900 dark:text-white truncate">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                        {{ ucfirst(str_replace('_',' ', auth()->user()->role)) }}
                    </p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Sign out"
                            class="p-1.5 rounded-lg text-gray-400 hover:text-red-500
                                   hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0
                                     01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Sidebar overlay (mobile) --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-black/50 lg:hidden"></div>

    {{-- ── Main area ───────────────────────────────────────── --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- Top bar --}}
        <header class="h-16 bg-white dark:bg-gray-900
                       border-b border-gray-200 dark:border-gray-800
                       flex items-center justify-between px-4 sm:px-6 flex-shrink-0">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true"
                        class="lg:hidden p-2 rounded-lg text-gray-500
                               hover:bg-gray-100 dark:hover:bg-gray-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div>
                    <h1 class="text-base font-semibold text-gray-900 dark:text-white">
                        @yield('page-title', 'Dashboard')
                    </h1>
                    @hasSection('page-subtitle')
                        <p class="text-xs text-gray-500 dark:text-gray-400">@yield('page-subtitle')</p>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-3">
                {{-- Dark mode --}}
                <button @click="darkMode = !darkMode"
                        class="p-2 rounded-lg text-gray-500 dark:text-gray-400
                               hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343
                                 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16
                                 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </button>

                {{-- Post job button --}}
                <a href="{{ route('company.jobs.create') }}" class="btn-primary text-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Post Job
                </a>
            </div>
        </header>

        {{-- Flash messages --}}
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show"
                 x-init="setTimeout(() => show = false, 4000)"
                 class="mx-4 sm:mx-6 mt-4 p-3 bg-green-50 dark:bg-green-900/30
                        border border-green-200 dark:border-green-700
                        text-green-800 dark:text-green-200 rounded-lg text-sm flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0
                         00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0
                         001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show"
                 x-init="setTimeout(() => show = false, 5000)"
                 class="mx-4 sm:mx-6 mt-4 p-3 bg-red-50 dark:bg-red-900/30
                        border border-red-200 dark:border-red-700
                        text-red-800 dark:text-red-200 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto p-4 sm:p-6">
            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
