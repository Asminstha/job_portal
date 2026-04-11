@extends('layouts.public')
@section('title', 'Sign In')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">

        {{-- Card --}}
        <div class="card p-8">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-brand-100 dark:bg-brand-900 rounded-xl mb-4">
                    <svg class="w-6 h-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Welcome back</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">Sign in to your account</p>
            </div>

            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           class="form-input @error('email') border-red-500 @enderror"
                           placeholder="you@company.com"
                           autofocus autocomplete="email">
                    @error('email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label for="password" class="form-label mb-0">Password</label>
                    </div>
                    <input type="password" id="password" name="password"
                           class="form-input @error('password') border-red-500 @enderror"
                           placeholder="••••••••"
                           autocomplete="current-password">
                    @error('password')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" id="remember" name="remember"
                           class="w-4 h-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                    <label for="remember" class="text-sm text-gray-600 dark:text-gray-400">
                        Keep me signed in
                    </label>
                </div>

                <button type="submit" class="btn-primary w-full justify-center py-2.5">
                    Sign in
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-800 text-center text-sm text-gray-500 dark:text-gray-400">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-brand-600 dark:text-brand-400 font-medium hover:underline">
                    Create one free
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
